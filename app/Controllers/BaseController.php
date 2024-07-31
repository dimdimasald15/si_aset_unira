<?php

namespace App\Controllers;


namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Pusher\Pusher;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];
    protected $session, $db, $uri;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function errorPage404()
    {
        $data = [
            'title' => 'Error 404',
            'msg' => 'Maaf tidak dapat diproses',
        ];
        return $data;
    }

    public function uploadFile($path, $file)
    {
        if (!is_dir($path))
            mkdir($path, 0777, TRUE);
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($path, $newName);
            return $path . $newName;
        }
        return "";
    }

    public function handleNotification()
    {
        $options = array(
            'cluster' => getenv('PUSHER_CLUSTER'),
            'useTLS' => true
        );
        $pusher = new Pusher(
            getenv('PUSHER_KEY'),
            getenv('PUSHER_SECRET'),
            getenv('PUSHER_APP_ID'),
            $options
        );

        return $pusher;
    }

    public function getBreadcrumb()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }

        return $breadcrumb;
    }
}
