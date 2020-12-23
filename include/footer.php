<div id="organizations_bottom"></div>
<hr />
<div class="container-fluid">
    &COPY;&nbsp;Принт-дизайн
</div>

<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.js'></script>
<script src="<?=APPLICATION ?>/js/jquery-ui.js"></script>

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
        
        $('input#edition.editable').focusout(function(){
            var edition = $(this).val();
            var id = $(this).parent().prev('#id').val();
            $(this).val('000');
            $.ajax({ url: "../ajax/edition.php?edition=" + edition + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
                editions.push(data);
                editions = editions.filter(unique).sort();
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
                organizations.push(data);
                organizations = organizations.filter(unique).sort();
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
            })
                    .fail(function() {
                        $(this).val('70773');
            });
        });
        
        $('select[id=user1_id],select[id=user2_id]').change(function(){
            if(this.value == '+') {
                $(this).parent().next().removeClass('d-none');
                $(this).parent().addClass('d-none');
                return;
            }
            this.form.submit();
        });
        
        $('select[id=roller_id]').focusout(function(){
            var roller_id = $(this).val();
            var id = $(this).prev('#id').val();
            $(this).val('');
            $.ajax({ url: "../ajax/edition.php?roller_id=" + roller_id + "&id=" + id, context: $(this) })
                    .done(function(data) {
                        $(this).val(data);
            })
                    .fail(function() {
                        alert('Ошибка при смене вала');
            });
        });
        
        $('select[id=lamination_id]').focusout(function(){
            var lamination_id = $(this).val();
            var id = $(this).prev('#id').val();
            $(this).val('');
            $.ajax({ url: "../ajax/edition.php?lamination_id=" + lamination_id + "&id=" + id, context: $(this) })
                    .done(function(data){
                        $(this).val(data);
                    })
                    .fail(function(){
                        alert('Ошибка при смене ламинации');
                    });
        });
        
        $('select[id=manager_id]').focusout(function(){
           var manager_id = $(this).val();
           var id = $(this).prev('#id').val();
           $(this).val('');
           $.ajax({ url: "../ajax/edition.php?manager_id=" + manager_id + "&id=" + id, context: $(this) })
                   .done(function(data){
                       $(this).val(data);
           })
                   .fail(function(){
                       alert('Ошибка при смене менеджера');
           });
        });
        
        $('input[type=date].copy').click(function(){
            $(this).val($(this).parent().parent().parent().parent().prev().prev().val());
        });
        
        $('button.confirmable').click(function(){
            return confirm('Действительно удалить?');
        });
        
        $('input[type=date]#from').change(function(){
            $('input[type=hidden].print_from').val($(this).val());
        });
        
        var organizations = [
            <?php
            $orgs = array();
            $fetcher = new Fetcher("select distinct organization from edition order by organization");
            while ($row = $fetcher->Fetch()) {
                if (count_chars($row['organization']) > 0) {
                    array_push($orgs, '"'.addslashes($row['organization']).'"');
                }
            }
            
            echo implode(",", $orgs);
            ?>
        ];
        $(".organizations").autocomplete({
            source: organizations
        });
        
        var editions = [
            <?php
            $eds = array();
            $fetcher = new Fetcher("select distinct name from edition order by name");
            while ($row = $fetcher->Fetch()) {
                if(count_chars($row['name']) > 0) {
                    array_push($eds, '"'.addslashes($row['name']).'"');
                }
            }
            
            echo implode(",", $eds);
            ?>
        ];
        $(".editions").autocomplete({
            source: editions
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