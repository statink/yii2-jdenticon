<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

declare(strict_types=1);

namespace statink\yii2\jdenticon;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Jdenticon extends Widget
{
    public $hash;
    public $size;
    public $class;
    public $params = [];
    public $vector = true;
    public $schema; // schema.org itemprop name

    public function run()
    {
        JdenticonAsset::register($this->view);

        if (!is_string($this->hash) || !preg_match('/^[0-9a-f]{32,}$/', $this->hash)) {
            throw new \Exception('Jdenticon::$hash must be set');
        }

        $params = (array)$this->params;
        if ($this->size > 0) {
            $params['width'] = (string)(int)$this->size;
            $params['height'] = $params['width'];
        }

        if ($this->class !== null) {
            $params['class'] = $params['class'];
        }

        if (!isset($params['data'])) {
            $params['data'] = [];
        }

        $params['data']['jdenticon-hash'] = $this->hash;
        $html = Html::tag(
            $this->vector ? 'svg' : 'canvas',
            '',
            $params
        );

        if ($this->schema) {
            $html = Html::tag(
                'span',
                implode('', [
                    Html::tag('meta', '', [
                        'itemprop' => 'url',
                        'content' => 'https://jdenticon.stat.ink/' . $this->hash . '.svg',
                    ]),
                    $html,
                ]),
                [
                    'itemscope' => true,
                    'itemtype' => 'http://schema.org/ImageObject',
                    'itemprop' => $this->schema,
                ]
            );
        }
        return $html;
    }
}
