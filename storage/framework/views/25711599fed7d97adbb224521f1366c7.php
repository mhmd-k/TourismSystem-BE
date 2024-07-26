<?php
    use Filament\Support\Facades\FilamentView;
?>

<?php if($this->hasUnsavedDataChangesAlert() && (! FilamentView::hasSpaMode())): ?>
        <?php
        $__scriptKey = '1896741956-0';
        ob_start();
    ?>
        <script>
            window.addEventListener('beforeunload', (event) => {
                if (window.jsMd5(JSON.stringify($wire.data).replace(/\\/g, '')) === $wire.savedDataHash) {
                    return
                }

                event.preventDefault()
                event.returnValue = true
            })
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php endif; ?>
<?php /**PATH C:\TourismSystem\vendor\filament\filament\resources\views\components\page\unsaved-data-changes-alert.blade.php ENDPATH**/ ?>