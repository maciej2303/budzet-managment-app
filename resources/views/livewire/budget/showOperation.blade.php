<div>
    <div name="content">
        <div class="mt-5">
        </div>
        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="showOperation">
            <x-slot name="title">
                Operacja
            </x-slot>
            <x-slot name="content">
                <div class="mt-4">
                    {{$operation->name ?? ''}}
                    {{$operation->created_at->format('d.m.Y') ?? ''}}
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('showOperation')" wire:loading.attr="disabled">
                    {{ __('Zamknij') }}
                </x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
