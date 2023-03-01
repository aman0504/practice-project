<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h2>
        hii

    </h2>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
        <script>
            function init() {
                const picker = new Litepicker({
                    element: document.getElementById('litepicker')
                });

            }

            window.addEventListener('load', () => {

                init();
            });
        </script>
    @endpush
</div>
