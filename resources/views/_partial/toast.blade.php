@if ($message = Session::get('success'))
<script>
    $(function() {
        'use strict';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
      
        Toast.fire({
            icon: 'success',
            title: '{{ session("success") }}'
        })
    })
</script>
@endif

@if ($message = Session::get('failed'))
<script>
    $(function() {
        'use strict';
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
      
      Toast.fire({
        icon: 'warning',
        title: '{{ session("failed") }}'
      })

    })
</script>
@endif