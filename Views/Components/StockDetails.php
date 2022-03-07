<div x-show="selectedStock" class="py-5">
    <div class="flex justify-center text-center" x-show="selectedStockBuyDate && selectedStockSellDate">
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 class="title-font font-medium text-3xl text-gray-900" x-text="selectedStockBuyDate"></h2>
                <p class="leading-relaxed">Buy</p>
            </div>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 class="title-font font-medium text-3xl text-gray-900" x-text="selectedStockSellDate"></h2>
                <p class="leading-relaxed">Sell</p>
            </div>
        </div>
    </div>
    <div class="flex justify-center text-center" x-show="analytics.quantity">
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 class="title-font font-medium text-3xl text-gray-900" x-text="analytics.quantity"></h2>
                <p class="leading-relaxed">Quantitiy</p>
            </div>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 class="title-font font-medium text-3xl text-gray-900" x-text="analytics.meanPrice"></h2>
                <p class="leading-relaxed">Mean price</p>
            </div>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 class="title-font font-medium text-3xl text-gray-900" x-text="analytics.deviation"></h2>
                <p class="leading-relaxed">Deviation</p>
            </div>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                <h2 :class="{'text-green-600': analytics.profit > 0}" class="title-font font-medium text-3xl text-red-600" x-text="analytics.profit"></h2>
                <p class="leading-relaxed">Total profit</p>
            </div>
        </div>
    </div>
</div>