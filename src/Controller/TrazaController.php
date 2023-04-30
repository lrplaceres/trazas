<?php

namespace App\Controller;

use App\Entity\Traza;
use App\Form\TrazaType;
use App\Repository\TrazaRepository;
use DateTime;
use LDAP\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/traza')]
class TrazaController extends AbstractController
{
    #[Route('/{anho}/index', name: 'app_traza_index', methods: ['GET'])]
    public function index(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/index.html.twig', [
            'trazas' => $trazaRepository->obtenerMesesYears($request->get('anho')),
            'denegados' => $trazaRepository->obtenerCodigoMesesYears($request->get('anho'), 'DENIED'),
            'perdidas' => $trazaRepository->obtenerCodigoMesesYears($request->get('anho'), 'MISS'),
            'anho' => $request->get('anho'),
        ]);
    }

    #[Route('/{anho}/{mes}/mes', name: 'app_traza_mes', methods: ['GET'])]
    public function mes(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mes.html.twig', [
            'trazas' => $trazaRepository->obtenerTrazaMesYears($request->get('anho'), $request->get('mes')),
            'denegados' => $trazaRepository->obtenerCodigoTrazaMesYears($request->get('anho'), $request->get('mes'), 'DENIED'),
            'perdidas' => $trazaRepository->obtenerCodigoTrazaMesYears($request->get('anho'), $request->get('mes'), 'MISS'),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
        ]);
    }

    #[Route('/{anho}/{mes}/dias', name: 'app_traza_mes_dias', methods: ['GET'])]
    public function mesDias(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesDias.html.twig', [
            'trazas' => $trazaRepository->obtenerTrazaMesYearsDias($request->get('anho'), $request->get('mes')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
        ]);
    }

    #[Route('/{anho}/{mes}/{codigo}/mes_codigo', name: 'app_traza_mes_codigo', methods: ['GET'])]
    public function mesDenegadas(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesCodigo.html.twig', [
            'denegados' => $trazaRepository->obtenerCodigoTrazaMesYears($request->get('anho'), $request->get('mes'), $request->get('codigo')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
        ]);
    }

    #[Route('/{anho}/{mes}/ip', name: 'app_traza_mes_ip', methods: ['GET'])]
    public function mesIP(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesIP.html.twig', [
            'denegados' => $trazaRepository->obtenerTrazaMesYearsIP($request->get('anho'), $request->get('mes')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
        ]);
    }

    #[Route('/{anho}/{mes}/uri', name: 'app_traza_mes_uri', methods: ['GET'])]
    public function mesURL(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesURI.html.twig', [
            'denegados' => $trazaRepository->obtenerTrazaMesYearsURI($request->get('anho'), $request->get('mes')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
        ]);
    }

    #[Route('/{anho}/{mes}/{user}/user', name: 'app_traza_mes_user', methods: ['GET'])]
    public function mesUser(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesUserAgrupadasURL.html.twig', [
            'trazas' => $trazaRepository->obtenerTrazaMesUserAgrupadasURL($request->get('anho'), $request->get('mes'), $request->get('user')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
            'user' => $request->get('user'),
        ]);
    }

    #[Route('/{anho}/{mes}/{user}/{url}/url', name: 'app_traza_mes_user_url', requirements: ['url' => '.+'], methods: ['GET'])]
    public function mesUserURL(TrazaRepository $trazaRepository, Request $request): Response
    {
        return $this->render('traza/mesUser.html.twig', [
            'trazas' => $trazaRepository->obtenerTrazaMesUserXURL($request->get('anho'), $request->get('mes'), $request->get('user'), $request->get('url')),
            'anho' => $request->get('anho'),
            'mes' => $request->get('mes'),
            'user' => $request->get('user'),
        ]);
    }

    #[Route('/{id}/show', name: 'app_traza_show', methods: ['GET'])]
    public function show(Traza $traza): Response
    {
        return $this->render('traza/show.html.twig', [
            'traza' => $traza,
        ]);
    }

    #[Route('/import', name: 'app_traza_import', methods: ['GET'])]
    public function importar(TrazaRepository $trazaRepository): Response
    {
        $fp = fopen("/home/xetid/Escritorio/trazas/log_squid/access.log.198", "r");
        while (!feof($fp)) {
            $linea[] = trim(fgets($fp));
        }

        fclose($fp);

        foreach ($linea as $valor) {
            $dividido = explode(" ", $valor);

            foreach ($dividido as $d) {
                if ($d != "") {
                    $v[] = $d;
                }
            }

            $date = new DateTime();
            $date->setTimestamp($v[0]);
            $date->format('Y-m-d H:i:s');

            $traza = new Traza();
            $traza->setFecha($date);
            $traza->setTimeproxy((int)$v[1]);
            $traza->setIp($v[2]);
            $traza->setResultCacheCode($v[3]);
            $traza->setLenghtContent((float)$v[4]);
            $traza->setMethod($v[5]);
            $traza->setUrl($v[6]);
            $traza->setUsername($v[7]);
            $traza->setProxyHierarcheRoute($v[8]);
            $traza->setContentType($v[9]);
            $trazaRepository->save($traza, true);
            $v = null;
        }
        return $this->redirectToRoute('app_traza_index', [], Response::HTTP_SEE_OTHER);
    }
}
