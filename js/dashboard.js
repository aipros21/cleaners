/**
 * FindMyCleaner - Dashboard JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        initSidebarToggle();
        initLeadExpand();
        initPhotoUpload();
        initConfirmActions();
    });

    // ==========================================
    // SIDEBAR TOGGLE (Mobile)
    // ==========================================
    function initSidebarToggle() {
        $('.navbar-toggler').on('click', function() {
            $('.dashboard-sidebar').toggleClass('show');
        });

        // Close sidebar on content click (mobile)
        $('.dashboard-content').on('click', function() {
            if (window.innerWidth < 992) {
                $('.dashboard-sidebar').removeClass('show');
            }
        });
    }

    // ==========================================
    // LEAD DETAIL EXPAND
    // ==========================================
    function initLeadExpand() {
        $(document).on('click', '.lead-toggle', function() {
            var $target = $($(this).data('target'));
            $target.toggleClass('show');
            $(this).find('i').toggleClass('ti-angle-down ti-angle-up');
        });

        // Lead status update
        $(document).on('change', '.lead-status-select', function() {
            var $select = $(this);
            var assignmentId = $select.data('id');
            var newStatus = $select.val();

            $.post(window.location.href, {
                action: 'update_lead_status',
                assignment_id: assignmentId,
                status: newStatus,
                csrf_token: $('input[name="csrf_token"]').val()
            }, function(data) {
                if (data.success) {
                    $select.closest('tr').find('.status-badge').attr('class', 'badge status-badge badge-' + getStatusColor(newStatus)).text(newStatus);
                }
            }, 'json');
        });
    }

    function getStatusColor(status) {
        var colors = {
            'sent': 'primary', 'viewed': 'info', 'accepted': 'success',
            'contacted': 'warning', 'completed': 'success', 'declined': 'danger'
        };
        return colors[status] || 'secondary';
    }

    // ==========================================
    // PHOTO UPLOAD (Dropzone)
    // ==========================================
    function initPhotoUpload() {
        if (typeof Dropzone === 'undefined' || !$('#photoDropzone').length) return;

        Dropzone.autoDiscover = false;

        new Dropzone('#photoDropzone', {
            url: window.location.href + '?upload=1',
            maxFilesize: 10, // MB
            acceptedFiles: 'image/jpeg,image/png,image/gif,image/webp',
            maxFiles: 50,
            parallelUploads: 2,
            addRemoveLinks: true,
            dictDefaultMessage: '<i class="ti-cloud-up" style="font-size:40px;color:#00b894;"></i><br>Drop photos here or click to upload',
            headers: {
                'X-CSRF-Token': $('input[name="csrf_token"]').val()
            },
            success: function(file, response) {
                if (response.success) {
                    // Reload page to show new photos
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    file.previewElement.classList.add('dz-error');
                    $(file.previewElement).find('.dz-error-message span').text(response.error || 'Upload failed');
                }
            },
            error: function(file, message) {
                file.previewElement.classList.add('dz-error');
                $(file.previewElement).find('.dz-error-message span').text(typeof message === 'string' ? message : 'Upload error');
            }
        });
    }

    // ==========================================
    // DELETE CONFIRMATIONS
    // ==========================================
    function initConfirmActions() {
        $(document).on('click', '.confirm-delete', function(e) {
            if (!confirm('Are you sure you want to delete this? This action cannot be undone.')) {
                e.preventDefault();
            }
        });

        $(document).on('click', '.confirm-action', function(e) {
            var message = $(this).data('confirm') || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    }

    // ==========================================
    // REVIEW RESPONSE TOGGLE
    // ==========================================
    $(document).on('click', '.respond-toggle', function() {
        $(this).closest('.review-card').find('.respond-form').slideToggle();
    });

    // ==========================================
    // SPECIALTY ADD
    // ==========================================
    $(document).on('submit', '#addSpecialtyForm', function(e) {
        e.preventDefault();
        var $input = $(this).find('input[name="specialty_name"]');
        var name = $input.val().trim();
        if (!name) return;

        $.post(window.location.href, {
            action: 'add_specialty',
            specialty_name: name,
            csrf_token: $('input[name="csrf_token"]').val()
        }, function(data) {
            if (data.success) {
                location.reload();
            }
        }, 'json');
    });

})(jQuery);
