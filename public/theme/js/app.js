    $(document).ready(function() {
        
        // Pure jQuery Multi-Language Tabs Switcher (No Bootstrap JS Needed)
        $(document).on('click', '[data-bs-toggle="tab"]', function (event) {
            event.preventDefault();
            
            var targetPaneId = $(this).attr('data-bs-target');
            
            var $nav = $(this).closest('.nav-tabs');
            $nav.find('button')
                .addClass('text-secondary border-0 bg-transparent')
                .removeClass('active bg-white border border-bottom-0')
                .attr('aria-selected', 'false');
            
            $(this)
                .addClass('active bg-white border border-bottom-0')
                .removeClass('text-secondary border-0 bg-transparent')
                .attr('aria-selected', 'true');

            var $contentContainer = $(targetPaneId).parent();
            
            $contentContainer.children('.tab-pane').removeClass('show active').css('display', 'none');
            
            $(targetPaneId).addClass('show active').css('display', 'block');
        });

        $(document).on('click', '.edit-slug-btn', function() {
            var targetInputId = $(this).data('target');
            var inputField = $('#' + targetInputId);
            
            if (inputField.prop('readonly')) {
                inputField.removeAttr('readonly').removeClass('bg-light').focus();
                $(this).text('Lock Slug').removeClass('btn-dark').addClass('btn-warning');
            } else {
                inputField.attr('readonly', true).addClass('bg-light');
                $(this).text('Edit Slug').removeClass('btn-warning').addClass('btn-dark');
            }
        });
    });
