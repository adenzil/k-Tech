<div x-data="store()" class="px-6">
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Welcome to K Tech</p>
            </div>
        </div>
    </div>
    <div class="flex justify-center flex-col">
        <?php
            require_once 'Views/Components/FileUpload.php';
            require_once 'Views/Components/StockList.php';
            require_once 'Views/Components/StockDetails.php';
        ?>
    </div>
</div>