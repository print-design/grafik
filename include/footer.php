<hr />
<div class="container-fluid">
    &COPY;&nbsp;Принт-дизайн
</div>

<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.js'></script>

<script>
    $(document).ready(function(){
        $('.int-only').keypress(function(e) {
            if(/\D/.test(String.fromCharCode(e.charCode))) {
                return false;
            }
        });
        
        $('.float-only').keypress(function(e) {
            if(!/[\.\d]/.test(String.fromCharCode(e.charCode))) {
                return false;
            }
        });
        
        $('input').keypress(function(){
            $(this).removeClass('is-invalid');
        });
        
        $('select').change(function(){
            $(this).removeClass('is-invalid');
        });
        
        $('.editable').keypress(function(){
            $(this).next('.d-none').removeClass('d-none');
        });
        
        $('.editable').change(function(){
            $(this).next('.d-none').removeClass('d-none');
        });
        
        $('input#name.editable').focusout(function(){
            var name = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?name=" + name + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                $(this).next('.input-group-append').addClass('d-none');
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('input#organization.editable').focusout(function(){
            var organization = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?organization=" + organization + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                $(this).next('.input-group-append').addClass('d-none');
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('input#length.editable').focusout(function(){
            var length = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?length=" + length + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                $(this).next('.input-group-append').addClass('d-none');
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('input#coloring.editable').focusout(function(){
            var coloring = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?coloring=" + coloring + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                $(this).next('.input-group-append').addClass('d-none');
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('input#comment.editable').focusout(function(){
            var comment = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?comment=" + comment + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                $(this).next('.input-group-append').addClass('d-none');
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('select[id=user1_id],select[id=user2_id],select[id=roller_id],select[id=lamination_id],select[id=manager_id]').change(function(){
            if(this.value == '+') {
                $(this).parent().next().removeClass('d-none');
                $(this).parent().addClass('d-none');
                return;
            }
            this.form.submit();
        });
        
        $('button.confirmable').click(function(){
            return confirm('Действительно удалить?');
        });
        
        <?php if (!empty($_REQUEST['scroll'])): ?>
        window.scrollTo(0, <?php echo intval($_REQUEST['scroll']); ?>);
        <?php endif; ?>
    });
    
    $(window).on("scroll", function(){
        $('input[name="scroll"]').val($(window).scrollTop());
        
        if($('thead#grafik-thead').length > 0 && $('tbody#grafik-tbody').length > 0) {
            var windowTop = $(window).scrollTop();
            var headHeight = $('thead#grafik-thead').height();
            var bodyTop = $('tbody#grafik-tbody').offset().top;
            var bodyPosition = $('tbody#grafik-tbody').offset().top - windowTop;
            
            if(bodyPosition < headHeight) {
                $('thead#grafik-thead').css('transform', 'translate3d(0, ' + (windowTop - bodyTop + headHeight) + 'px, 100px)');
            }
            else {
                $('thead#grafik-thead').css('transform', 'none');
            }
        }
    });
</script>