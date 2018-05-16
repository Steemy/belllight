(function($) {
    'use sctrict'
    $.backendList = {
        init: function() {
            this.initDelete();
        },
        initDelete: function() {
            $('.list__delete').click(function(event) {
                if(!confirm("Удалить?"))
                    return false;

                var id =  $(this).data('id');
                var tr = $(this).closest('tr');

                $.post('?plugin=belllight&action=delete', { 'id': id }, function (response) {
                    if (response.data.status) {
                        tr.fadeOut('slow', function() {
                            tr.remove();
                        });
                    }
                }, "json");
            });
        }
    }

    $.backendList.init();

})(jQuery);