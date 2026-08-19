<?php

use App\Models\Signee;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Signee $user;
    public string $message = '';
    public bool $private = false;
    public string $name = '';
    public bool $isAnonymous = false;

    public function mount(string $userId)
    {
        $this->user = Signee::where('alt_id', $userId)->orWhere('id', $userId)->firstOrFail();

        // Security check
        if (!app()->isLocal() && Auth::guard('signee')->id() !== $this->user->id) {
            abort(403);
        }

        $this->message = $this->user->message ?? '';
        $this->private = (bool) ($this->user->private ?? false);
        $this->isAnonymous = empty($this->user->name) || $this->user->name === 'Anonymous';
        $this->name = $this->isAnonymous ? '' : $this->user->name;
    }

    public function save()
    {
        // Double check auth
        if (!app()->isLocal() && Auth::guard('signee')->id() !== $this->user->id) {
            abort(403);
        }

        $this->validate([
            'message' => 'required|string|max:1000',
            'private' => 'boolean',
            'name' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'message' => $this->message,
            'private' => $this->private,
        ];

        if (!empty(trim($this->name))) {
            $updateData['name'] = trim($this->name);
        }

        $this->user->update($updateData);

        $this->dispatch('guestbook-signed');
        
        $this->js('$flux.modal("guestbook-modal").close()');

        return redirect()->to('/#guestbook')->with('status', 'Thank you for signing the guestbook!');
    }
}; ?>

<form wire:submit="save" class="space-y-6">
    <div class="space-y-2">
        <flux:heading size="lg">Hello, {{ $user->first_name }}!</flux:heading>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm">
            We've detected your location as <span class="text-pale-night-blue font-bold">
                @if($user->city && $user->state)
                    {{ $user->city }}, {{ $user->state }}
                @elseif($user->city)
                    {{ $user->city }}
                @else
                    {{ $user->place_id ?? 'our global community' }}
                @endif
            </span>.
        </p>
    </div>

    @if(empty($user->name) || $user->name === 'Anonymous')
        <flux:input 
            wire:model="name" 
            label="Your Name (Optional)" 
            placeholder="Enter your name if you'd like to share it" 
            description="Since your login didn't provide a name, you're listed as Anonymous by default."
        />
    @endif

    <flux:textarea
        wire:model="message" 
        label="Message" 
        placeholder="What's on your mind?" 
        rows="4"
        description="Share a thought, a greeting, or just say hi!"
    />

    <flux:checkbox 
        wire:model="private" 
        label="Keep this message private" 
        description="Only public messages are displayed on the global map."
    />
    
    <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-8">
        <flux:modal.close>
            <x-button class="text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 w-full sm:w-auto">Cancel</x-button>
        </flux:modal.close>
        @if(Auth::guard('signee')->user()->social_auth_type === 'github')
            <x-button href="https://github.com/blhamm/bhamm.dev" target="_blank" class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10 w-full sm:w-auto">
                <flux:icon.star class="mr-2 size-4" />
                Star on GitHub
            </x-button>
        @endif
        <x-button type="submit" wire:loading.attr="disabled" class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20 w-full sm:w-auto">
            <span wire:loading.remove>Post to Guestbook</span>
            <span wire:loading>Posting...</span>
        </x-button>
    </div>
</form>
