<div x-show="uniqueStockNames.length" class="py-5">
    <input type="text" id="inputStockName" x-ref="stockInput" class="border-2 border-gray-200 p-3 w-full block rounded cursor-pointer my-2" placeholder="Select a stock" />
    <div class="float-right" @click="showDateFilter = ! showDateFilter">
        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="">
        <label class="form-check-label inline-block text-gray-800">Show date filter</label>
    </div>
    <div class="ui-widget py-10" x-show="failureMessage">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
            <p>
                <span class="ui-icon ui-icon-alert" 
                    style="float: left; margin-right: .3em;"></span>
                <strong>Alert:</strong> <span x-text="failureMessage">Sample ui-state-error style.</span>
            </p>
        </div>
    </div>
</div>
<div x-show="selectedStock.length && showDateFilter" class="py-5">
    <div class="pb-5 md:flex md:justify-center md:items-center">
        <div class="mr-5">
            <span>Start date:</span>
            <input type="text" x-ref="startDate" class="pr-5 border-2 border-gray-200 p-3 block rounded cursor-pointer mb-2" />
        </div>
        <div class="mr-5">
            <span>End date:</span>
            <input type="text" x-ref="endDate" class="border-2 border-gray-200 p-3 block rounded cursor-pointer mb-2" />
        </div>
        <button @click.prevent="getDetailsByDates" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Get by custom date</button>
    </div>
</div>