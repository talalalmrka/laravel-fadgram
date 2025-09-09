<?php

namespace App\Livewire\Dashboard\Terminal;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Symfony\Component\Console\Output\StreamOutput;

class Index extends Component
{
    public $command = '';
    public $output = ''; // We don't need this as a property anymore; streaming handles it.

    protected $rules = [
        'command' => 'required|string',
    ];

    public function addLine($line)
    {
        $this->output .= "\n";
        $this->output .= $line;
    }
    public function runCommand()
    {
        $this->authorize('manage_settings');
        $this->validate();

        // Stream the command echo first for a terminal-like feel.
        // $this->stream('output', "\n> php artisan {$this->command}\n");
        $this->addLine("> php artisan {$this->command}");

        try {
            // Use a callback to stream output line-by-line as it's generated.
            /* Artisan::call($this->command, [], function ($type, $buffer) {
                // $type is 'line' or 'raw'; we stream the buffer directly.
                // $this->stream('output', $buffer);
                $this->addLine($buffer);
            }); */
            Artisan::call($this->command);
            $this->addLine(Artisan::output());
            // After completion, add a newline for separation.
            // $this->stream('output', "\n");
            // $this->output .= "\n";
        } catch (\Exception $e) {
            $this->addLine("Error: {$e->getMessage()}");
            // $this->stream('output', "Error: {$e->getMessage()}\n\n");
        }

        $this->command = '';
        $this->js('scrollToBottom'); // Trigger JS event for auto-scroll.
    }

    public function render()
    {
        return view('livewire.dashboard.terminal.index')->layout('layouts.dashboard', [
            'title' => __('Terminal'),
        ]);
    }
}
