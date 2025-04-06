<x-dialog :title="__('Upload files')">
    <fgx:file id="files" wire:model.live="files" :label="__('Files')" multiple :previews="$filesPreviews" />
</x-dialog>
