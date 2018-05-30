<?php

namespace Modules\Core\Console\Installer\Traits;

trait SectionMessage
{
    public function sectionMessage(...$messages)
    {
        $formatter = $this->getHelperSet()->get('formatter');
        $formattedLine = $formatter->formatSection($messages);

        $this->line($formattedLine);
    }
}
