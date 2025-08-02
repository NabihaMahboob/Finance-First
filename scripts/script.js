// Budget Chart Configuration (from file 1)
function initBudgetChart(income, expense) {
    const ctx = document.getElementById('budgetChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    label: 'Budget',
                    data: [income, expense],
                    backgroundColor: ['#4caf50', '#f44336'],
                    borderWidth: 1
                }]
            }
        });
    }
}

// TradingView Widget Configuration (from file 2)
function initTradingViewWidget() {
    // Check if the widget container exists
    const widgetContainer = document.querySelector('.investment_chart_widget');
    if (widgetContainer) {
        // Create script element for TradingView widget
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js';
        script.async = true;
        
        // Widget configuration
        script.text = JSON.stringify({
            "allow_symbol_change": true,
            "calendar": false,
            "details": false,
            "hide_side_toolbar": true,
            "hide_top_toolbar": false,
            "hide_legend": false,
            "hide_volume": false,
            "hotlist": false,
            "interval": "D",
            "locale": "en",
            "save_image": true,
            "style": "1",
            "symbol": "NASDAQ:AAPL",
            "theme": "light",
            "timezone": "Etc/UTC",
            "backgroundColor": "#ffffff",
            "gridColor": "rgba(46, 46, 46, 0.06)",
            "watchlist": [],
            "withdateranges": false,
            "compareSymbols": [],
            "studies": [],
            "autosize": true
        });
        
        // Append script to widget container
        widgetContainer.appendChild(script);
    }
}

// Initialize functions when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TradingView widget if on investment page
    initTradingViewWidget();
    
    // Note: Budget chart will need to be initialized with PHP data
    // Example usage: initBudgetChart(1000, 750); // Pass actual values from PHP
});

// Utility function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Additional utility functions that might be useful
const FinanceUtils = {
    // Calculate percentage of budget used
    calculateBudgetPercentage: function(expense, income) {
        if (income === 0) return 0;
        return Math.round((expense / income) * 100);
    },
    
    // Validate form inputs
    validateAmount: function(amount) {
        return !isNaN(amount) && amount > 0;
    },
    
    // Format numbers for display
    formatNumber: function(num, decimals = 2) {
        return parseFloat(num).toFixed(decimals);
    }
};