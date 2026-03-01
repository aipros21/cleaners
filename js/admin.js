/**
 * FindMyCleaner - Admin JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        initSidebarToggle();
        initConfirmActions();
        initCharts();
        initQuickActions();
        initSlugGeneration();
    });

    // ==========================================
    // SIDEBAR TOGGLE
    // ==========================================
    function initSidebarToggle() {
        $('.navbar-toggler').on('click', function() {
            $('.dashboard-sidebar').toggleClass('show');
        });
    }

    // ==========================================
    // CONFIRM ACTIONS
    // ==========================================
    function initConfirmActions() {
        $(document).on('click', '.confirm-delete', function(e) {
            if (!confirm('Are you sure you want to delete this?')) e.preventDefault();
        });

        $(document).on('click', '.confirm-action', function(e) {
            if (!confirm($(this).data('confirm') || 'Are you sure?')) e.preventDefault();
        });
    }

    // ==========================================
    // CHARTS (Chart.js)
    // ==========================================
    function initCharts() {
        // Revenue Chart
        var $revenueChart = document.getElementById('revenueChart');
        if ($revenueChart && typeof Chart !== 'undefined') {
            var ctx = $revenueChart.getContext('2d');
            var data = JSON.parse($revenueChart.dataset.chartData || '{}');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        label: 'Revenue',
                        data: data.values || [],
                        borderColor: '#00b894',
                        backgroundColor: 'rgba(0,184,148,0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: function(v) { return '$' + v; } } }
                    }
                }
            });
        }

        // Leads by Category Chart
        var $leadsChart = document.getElementById('leadsCategoryChart');
        if ($leadsChart && typeof Chart !== 'undefined') {
            var ctx2 = $leadsChart.getContext('2d');
            var data2 = JSON.parse($leadsChart.dataset.chartData || '{}');

            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: data2.labels || [],
                    datasets: [{
                        label: 'Leads',
                        data: data2.values || [],
                        backgroundColor: '#00b894'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        // Cleaner Growth Chart
        var $growthChart = document.getElementById('growthChart');
        if ($growthChart && typeof Chart !== 'undefined') {
            var ctx3 = $growthChart.getContext('2d');
            var data3 = JSON.parse($growthChart.dataset.chartData || '{}');

            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: data3.labels || [],
                    datasets: [{
                        label: 'Cleaners',
                        data: data3.values || [],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40,167,69,0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }
    }

    // ==========================================
    // QUICK ACTIONS (verify, feature, suspend)
    // ==========================================
    function initQuickActions() {
        $(document).on('click', '.quick-action', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('href');

            $.post(url, {
                csrf_token: $('input[name="csrf_token"]').val()
            }, function(data) {
                if (data.success) {
                    location.reload();
                }
            }, 'json').fail(function() {
                // Fallback to regular link
                window.location.href = url;
            });
        });
    }

    // ==========================================
    // AUTO SLUG GENERATION
    // ==========================================
    function initSlugGeneration() {
        $(document).on('input', 'input[data-slug-source]', function() {
            var target = $(this).data('slug-target') || 'input[name="slug"]';
            var slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            $(target).val(slug);
        });
    }

})(jQuery);
