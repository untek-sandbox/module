<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Untek\Bundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use Untek\Component\Encoder\Encoders\XmlEncoder;
use Untek\Component\Web\Form\Libs\FormManager;
use Untek\Component\Web\TwBootstrap\Widgets\TabContent\TabContentWidget;
use Untek\Core\Container\Helpers\ContainerHelper;
use Untek\Core\FileSystem\Helpers\MimeTypeHelper;
use Untek\Core\Instance\Helpers\PropertyHelper;
//use Untek\Lib\Web\TwBootstrap\Widgets\TabContent\TabContentWidget;
use Untek\Lib\Web\View\Libs\View;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Helpers\EntityHelper;
//use ZnLib\Web\Widgets\TabContent\TabContentWidget;
use ZnLib\Web\Widgets\Table\TableWidget;

abstract class AbstractSandboxController //extends AbstractRestApiController
{

//    protected $layout = __DIR__ . '/../views/layouts/main.php';
    protected $viewsDir = __DIR__ . '/../views/common';
    protected $contentArray = [];
    protected $tabs = [];
    protected $dumps = [];
    protected $tabName = 'main';

    protected FormManager $formManager;
    protected SessionInterface $session;

    public function __construct()
    {
        $this->formManager = ContainerHelper::getContainer()->get(FormManager::class);
        $session = ContainerHelper::getContainer()->get(SessionInterface::class);
        $session->start();
        $this->session = $session;
    }

    protected function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse
    {
        return $this->redirect($this->generateUrl($route, $parameters), $status);
    }

    protected function redirectToHome(int $status = 302): RedirectResponse
    {
        return $this->redirect('/', $status);
    }

    protected function redirectToBack(Request $request, string $fallbackUrl = null): RedirectResponse
    {
        $referer = $request->headers->get('referer') ?? $fallbackUrl;
        //$request->getSession()->setFlash('error', $exception->getMessage());
        return new RedirectResponse($referer);
    }

    protected function redirect(string $url, int $status = HttpStatusCodeEnum::MOVED_TEMPORARILY): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    public function getToastr(): ToastrServiceInterface {
        /** @var ToastrServiceInterface $toastrService */
        $toastrService = ContainerHelper::getContainer()->get(ToastrServiceInterface::class);
        return $toastrService;
    }

    protected function toTab(string $tabName, bool $encode = true)
    {
        $this->tabName = $tabName;
    }

    protected function print(string $data)
    {
        $this->contentArray[$this->tabName][] = $data;
    }

    protected function dd($data)
    {
        $this->dumps[] = $data;
    }

    protected function assertEqual($expected, $actual)
    {
        if ($expected == $actual) {
            $this->alertSuccess('is equal!');
        } else {
            /*$message = $this->encodeJson([
                'expected' => $expected,
                'actual' => $actual,
            ]);*/
            $message = 'is not equal!
                <br/>
                expected:<br/><pre>' . $this->encodeJson($expected) . '</pre>
                actual:<br/><pre>' . $this->encodeJson($actual) . '</pre>';
            $this->alertDanger($message);
        }
    }

    protected function printBool(bool $value)
    {
        $this->alertInfo($value ? 'True' : 'False');
    }

    protected function printTable(array $value, array $headers = [])
    {
        if (!ArrayHelper::isIndexed($value)) {
            $rr = [];
            foreach ($value as $name => $value) {
                $rr[] = [$name, $value];
            }
            $value = $rr;
        }
        $html = TableWidget::widget([
            'tableClass' => 'table table-bordered table-striped table-condensed table-sm',
            'body' => $value,
            'header' => $headers,
        ]);
        $this->print($html);
    }

    protected function printSubmit()
    {
        $this->print('<p>
<form name="form" method="POST">
<div class="form-group">
    <button type="submit" id="form_save" class="btn btn-primary" name="form[save]">Отправить</button></div>

</form>
</p>');
    }

    protected function printForm()
    {
        $this->print();
    }

    protected function printHeader(string $message, int $level = 3)
    {
        $message = htmlspecialchars($message);
        $message = "<h$level>" . $message . "</h$level>";
        $this->print($message);
    }

    protected function printCode(string $message)
    {
        $message = htmlspecialchars($message);
        $message = '<pre>' . $message . '</pre>';
        $this->alertInfo($message);
    }

    protected function printPrettyXml($data)
    {
        $xmlEncoder = new XmlEncoder(true, 'UTF-8', false);
        if (!is_array($data)) {
            $data = $xmlEncoder->decode($data);
        }
        $this->printCode($xmlEncoder->encode($data));
    }

    protected function startBuffer()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    protected function endBuffer()
    {
        ob_get_clean();
    }

    protected function encodeJson($data)
    {
        $message = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $message;
    }

    protected function printObject(object $object)
    {
        $message = $this->encodeJson(PropertyHelper::toArray($object, true));
        $className = get_class($object);
        $message =
            '<pre>' .
            PHP_EOL .
            '<span class="float-left">' .
            $message .
            '</span>' .
            '<small class="float-right">' .
            $className .
            '</small>' .
            '</pre>';
        $this->alertInfo($message);
    }

    protected function dump($data)
    {
//        $message = $this->encodeJson($data);
//        $message = '<pre>' . $message . '</pre>';
//        $this->alertInfo($message);
        $this->dumps[] = $data;
    }

    protected function printArray(array $data)
    {
//        $this->dump($data);

        $message = $this->encodeJson($data);
        $message = '<pre>' . $message . '</pre>';
        $this->alertInfo($message);
    }

    /*protected function error(string $message, string $type = 'danger')
    {
        $alertContent = $this->alertToString($message, $type);
        $this->contentArray[$this->tabName][] = $alertContent;
    }

    protected function alert(string $message, string $type = 'success')
    {
        $alertContent = $this->alertToString($message, $type);
        $this->contentArray[$this->tabName][] = $alertContent;
    }*/

    protected function alertSuccess(string $message)
    {
        $alertContent = $this->alertToString($message, 'success');
        $this->contentArray[$this->tabName][] = $alertContent;
    }

    protected function alertWarning(string $message)
    {
        $alertContent = $this->alertToString($message, 'warning');
        $this->contentArray[$this->tabName][] = $alertContent;
    }

    protected function alertDanger(string $message)
    {
        $alertContent = $this->alertToString($message, 'danger');
        $this->contentArray[$this->tabName][] = $alertContent;
    }

    protected function alertInfo(string $message)
    {
        $alertContent = $this->alertToString($message, 'info');
        $this->contentArray[$this->tabName][] = $alertContent;
    }

    protected function renderFile(string $file, array $params = []): Response
    {
//        $content = $this->generateContent();
//        $params['content'] = $content;
//        return $this->render($file, $params);
//        $content = $this->generateContent();
//        $params['dumps'] = $this->dumps;
//        $params['content'] = $content . ($params['content'] ?? '');
        return $this->render($file, $params);
    }

    protected function generateContent()
    {
        $content = '';
        if ($this->contentArray) {
            if (count($this->contentArray) > 1) {
                $items = [];
                foreach ($this->contentArray as $tabName => $tabContentItems) {
                    $tabContent = '';
                    foreach ($tabContentItems as $tabContentItem) {
                        $tabContent .= $tabContentItem;
                    }
                    $items[] = [
                        'name' => $tabName,
                        'content' => $tabContent,
                    ];
                }
                $content .= TabContentWidget::widget([
                    'contentClass' => 'mt-3',
                    'items' => $items,
                ]);
            } else {
                if (isset($this->contentArray['main'])) {
                    foreach ($this->contentArray['main'] as $contentItem) {
                        $content .= $contentItem;
                    }
                }
            }
        }
        return $content;
    }

    protected function alertToString(string $message, string $type): string
    {
        if ($type == 'code') {
            $alertContent = '
                <div class="alert alert-info" role="alert">
                    <pre>' . $message . '</pre>
                </div>';
        } else {
            $alertContent = '
                <div class="alert alert-' . $type . '" role="alert">
                  ' . $message . '
                </div>';
        }
        return $alertContent;
    }

    protected function render(string $viewFile, array $params = []): Response
    {
        $content = $this->generateContent();
        $params['dumps'] = $this->dumps;
        $params['content'] = $content . ($params['content'] ?? '');

        $view = new View();
        $content = $view->renderFile($viewFile, $params);
        return new Response($content);
    }

    protected function renderDefault(array $params = [])
    {
        $viewFile = realpath(__DIR__ . '/../../../../resources/templates/default.php');
        return $this->renderFile($viewFile, $params);
    }

    protected function openFile(string $fileName, string $mime = null): Response
    {
        $mime = $mime ?: MimeTypeHelper::getMimeTypeByFileName($fileName);
        $response = new BinaryFileResponse($fileName, 200, ['Content-Type' => $mime]);
        return $response;
    }

    protected function downloadFile(string $fileName): Response
    {
        $mime = MimeTypeHelper::getMimeTypeByFileName($fileName);
        $response = new BinaryFileResponse($fileName);
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', basename($fileName)));
//        $response->setContent(file_get_contents($fileName));
//        $response->setStatusCode(200);
        $response->headers->set('Content-Type', $mime);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;
    }
}