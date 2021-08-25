<div>
    <div name="content">
        <div class="mt-5">
        </div>

        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="creating">
            <x-slot name="title">
                {{ __('Dodawanie nowego użytkownika') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                <x-jet-label for="invitationLink" value="{{ __('Link') }}" />
                    <x-jet-input type="invitationLink" class="mt-1 block w-3/4" id="link" readonly
                                x-ref="invitationLink"
                                wire:model.defer="invitationLink"
                                wire:keydown.enter="save" />
                    <x-jet-button class="mt-3" value="copy" onclick="copyToClipboard()">Kopiuj do schowka</x-jet-button>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-button wire:click="$toggle('creating')" wire:loading.attr="disabled">
                    {{ __('Zamknij') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
@push('js')
    <script>
    function copyToClipboard() {
        document.getElementById('link').select();
        document.execCommand('copy');
    }
</script>
@endpush
