<?php

namespace Modules\Core\Console\Installer\Traits;

trait BlockMessage
{
    public function blockMessage($style, ...$messages)
    {
        $formatter = $this->getHelperSet()->get('formatter');
        $formattedBlock = $formatter->formatBlock($messages, $style, true);

        $this->line($formattedBlock);
    }
}
