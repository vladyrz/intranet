<?php

namespace App\Filament\Personal\Pages;

use Filament\Pages\Page;

class LegalNotice extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'pages.legal-notice-public';
    protected static ?string $title = 'Términos y condiciones';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
