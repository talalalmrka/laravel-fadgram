<fgx:switch :checked="$font->enabled" wire:change="toggleFont('{{ $font->id }}', $event.target.checked)" />
