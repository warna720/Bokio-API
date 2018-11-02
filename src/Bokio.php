<?php
declare(strict_types=1);

namespace warna720\Bokio;

use Nesk\Puphpeteer\Puppeteer;

/**
 * Class Bokio
 * @package warna720\Bokio
 */
class Bokio
{
    protected static $RESOLUTION = ['width' => 1920, 'height' => 1080];
    protected static $BASE_URL = "https://app.bokio.se/login";

    public function __construct() {}

    public function createBookRecord(string $document_path) {
        $this
            ->createBrowser()
            ->newPage()
            ->login(
                (string)config('bokio.email'),
                (string)config('bokio.password')
            )->uploadDocument($document_path)
            ->closePage()
            ->closeBrowser();
    }

    protected function createBrowser() : self {
        $this->puppeteer = new Puppeteer([
            'debug' => config('bokio.debug'),
        ]);

        $this->browser = $this->puppeteer->launch([
            'args' => [
                config('bokio.disable_sandbox') ? '--no-sandbox' : '',
                config('bokio.disable_setuid_sandbox') ? '--disable-setuid-sandbox' : '',
            ],
        ]);

        return $this;
    }

    protected function closeBrowser() : self {
        $this->browser->close();

        return $this;
    }

    protected function newPage() : self {
        $this->page = $this->browser->newPage();
        $this->page->setJavaScriptEnabled(true);
        $this->page->setViewport(self::$RESOLUTION);

        return $this;
    }

    protected function closePage() : self {
        $this->page->close();

        return $this;
    }

    protected function login(string $email, string $password) : self {
        $this->page->goto(self::$BASE_URL);
        $this->page->type('input[name="userName"]', $email);
        $this->page->type('input[name="password"]', $password);
        $this->page->click('button[type=submit]');
        $this->page->waitForNavigation();

        return $this;
    }

    protected function uploadDocument(string $document_path) : self {
        while ($this->page->querySelector('input[id="uploadFile"]') == null) {}
        $this->page
            ->querySelector('input[id="uploadFile"]')
            ->uploadFile($document_path);

        return $this;
    }
}
