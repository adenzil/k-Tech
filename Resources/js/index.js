function store() {
    return {
        files: null,
        allStockTransactions: [],
        uniqueStockNames: [],
        selectedStock: '',
        selectedStockBuyDate: '',
        selectedStockSellDate: '',
        selectedStockTransactions: [],
        startDate: '',
        endDate: '',
        showDateFilter: false,
        analytics: {},
        failureMessage: '',
        init() {
            $(this.$refs.startDate).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
            $(this.$refs.endDate).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
            $(this.$refs.stockInput).autocomplete({
                source: [],
                minLength: 0,
            }).focus(function() {
                $(this).autocomplete('search', $(this).val())
            });
            $(this.$refs.stockInput).on('autocompleteselect', (event, ui) => {
                this.selectedStock = ui.item.value
                this.resetData()
                $(this.$refs.startDate).datepicker('setDate', null);
                $(this.$refs.endDate).datepicker('setDate', null);
                this.getDetailsByStock()
            })
        },
        updateFile(e) {
            this.files = Object.values(e.target.files)
        },
        submitCsvFile(e) {
            let formData = new FormData();
            formData.append("file", this.files[0]);
            fetch('/api/CSVUpload.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status == 'success') {
                    this.allStockTransactions = res.data.stocks
                    this.uniqueStockNames = res.data.uniqueStockNames
                    // Update autcomplete source
                    $(this.$refs.stockInput).autocomplete("option", { source : this.uniqueStockNames })
                    // Set min and max date based on first and last transaction date
                    // convert date format from mm-dd-yy to dd-mm-yy
                    let startDate = this.allStockTransactions[0].date.split("-")
                    let endDate = this.allStockTransactions[this.allStockTransactions.length - 1].date.split("-")
                    $(this.$refs.startDate).datepicker("change", {
                        minDate: new Date(startDate[2], startDate[1] - 1, startDate[0]),
                        maxDate: new Date(endDate[2], endDate[1] - 1, endDate[0])
                    })
                    $(this.$refs.endDate).datepicker("change", {
                        minDate: new Date(startDate[2], startDate[1] - 1, startDate[0]),
                        maxDate: new Date(endDate[2], endDate[1] - 1, endDate[0])
                    })
                }
            })
            .catch(() => {
            })
            .finally(() => {
            })
        },
        getDetailsByStock() {
            if(!this.selectedStock)
                return;
            url = `/api/CSVUpload.php?selectedStock=${this.selectedStock}`
            if(this.startDate) {
                url += `&startDate=${this.startDate}`
                if(this.endDate)
                    url += `&endDate=${this.endDate}`
            }
            fetch(url, {
                method: 'POST',
            })
            .then(res => res.json())
            .then(res => {
                this.resetData()
                if(res.status == 'failure') {
                    this.failureMessage = res.message
                } else {
                    this.selectedStockBuyDate = res.data.bestDates.buy.date ? res.data.bestDates.buy.date : ''
                    this.selectedStockSellDate = res.data.bestDates.sell.date ? res.data.bestDates.sell.date : ''
                    this.analytics.quantity = res.data.analytics.quantity 
                    this.analytics.meanPrice = res.data.analytics.meanPrice 
                    this.analytics.profit = res.data.analytics.profit
                    this.analytics.deviation = res.data.analytics.deviation
                    this.selectedStockTransactions = res.data.allTransactions
                }
            })
            .catch(() => {
            })
            .finally(() => {
            })
        },
        getDetailsByDates() {
            this.startDate = $(this.$refs.startDate).val()
            this.endDate = $(this.$refs.endDate).val()
            this.getDetailsByStock()
        },
        resetData() {
            this.startDate = this.endDate = this.selectedStockBuyDate = this.selectedStockSellDate = this.failureMessage = ''
            this.analytics = {}
            this.selectedStockTransactions = []
        }
    }
}
