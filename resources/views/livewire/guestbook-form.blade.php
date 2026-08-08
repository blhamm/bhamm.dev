<?php

use App\Models\GuestBookUser;
use Livewire\Volt\Component;

new class extends Component {
    public GuestBookUser $user;
    public string $message = '';
    public bool $private = false;

    public function mount(int $userId)
    {
        $this->user = GuestBookUser::findOrFail($userId);
        $this->message = $this->user->message ?? '';
        $this->private = (bool) ($this->user->private ?? false);
    }

    public function save()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
            'private' => 'boolean',
        ]);

        $this->user->update([
            'message' => $this->message,
            'private' => $this->private,
        ]);

        $this->dispatch('guestbook-signed');
        
        return redirect()->to('/')->with('status', 'Thank you for signing the guestbook!');
    }
}; ?>

<form wire:submit="save" class="space-y-6">
    <div class="space-y-2">
        <flux:heading size="lg">Hello, {{ $user->name }}!</flux:heading>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm">
            We've detected your location as <span class="text-pale-night-blue font-bold">{{ $user->place_id ?? 'the grid' }}</span>.
        </p>
    </div>

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
    
    <div class="flex justify-end gap-3 mt-8">
        <flux:modal.close>
            <x-button class="text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20">Cancel</x-button>
        </flux:modal.close>
        <x-button type="submit" class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20">
            Post to Guestbook
        </x-button>
    </div>
</form>
