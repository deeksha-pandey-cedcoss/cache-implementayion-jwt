<?php

namespace MyApp;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

class Locale extends Injectable
{
    /**
     * @return NativeArray
     */
    public function getTranslator(): NativeArray
    {
        session_start();
        if (isset($_SESSION['lang'])) {

            $language = $_SESSION['lang'];


            $messages = [];

            $translationFile = APP_PATH . '/messages/' . $language;

            if (true !== file_exists($translationFile)) {
                $translationFile = APP_PATH . '/messages/en-GB.php';
            }

            require $translationFile;

            $interpolator = new InterpolatorFactory();
            $factory      = new TranslateFactory($interpolator);

            return $factory->newInstance(
                'array',
                [
                    'content' => $messages,
                ]
            );
        } else {
            $language = $this->request->getBestLanguage();
            $messages = [];
            $translationFile = APP_PATH . '/messages/' . $language;

            if (true !== file_exists($translationFile)) {
                $translationFile = APP_PATH . '/messages/en-GB.php';
            }
            require $translationFile;

            $interpolator = new InterpolatorFactory();
            $factory      = new TranslateFactory($interpolator);

            return $factory->newInstance(
                'array',
                [
                    'content' => $messages,
                ]
            );
        }
    }
}
