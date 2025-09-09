<div class="p-3 bg-gray-900 rounded text-white font-mono text-sm">
    <div>
        <div class="rounded h-84 overflow-auto mb-2" id="output">
            <pre class="whitespace-pre-wrap break-words bg-transparent p-2">{{ $output }}</pre>
        </div>
    </div>
    <form wire:submit.prevent="runCommand" class="flex gap-2">
        <input type="text" wire:model.live="command" placeholder="Enter command (e.g., migrate)"
            class="appearance-none focus:outline-0 border-0 w-full h-auto bg-gray-800 text-white placeholder-gray-400 p-2 rounded"
            autofocus />
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Run</button>
    </form>
</div>
@script
    <script>
        $js('scrollToBottom', () => {
            $nextTick(() => {
                console.log('scrollToBottom');

                const output = document.querySelector('#output');
                console.log('output', output);
                console.log(output.scrollHeight);
                output.scrollTop = output.scrollHeight;
            });

        })
    </script>
@endscript
