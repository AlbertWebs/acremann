<?php

namespace App\Filament\Support;

use Filament\Forms\Components\RichEditor;

class FormComponents
{
    public static function richEditor(string $name): RichEditor
    {
        return RichEditor::make($name)
            ->columnSpanFull()
            ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'strike',
                'link',
                'h2',
                'h3',
                'bulletList',
                'orderedList',
                'blockquote',
                'redo',
                'undo',
            ]);
    }
}
