<div id="homeoem">
    <div class="service">
        <div class="content">
            <div class="viewImg">
                @for($i=1;$i<=10;$i++)
                <img src="/ksn/images/homeoem/{{$i}}.png" onclick="warning()"  />
                @endfor
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const warning = ()=>{
            Swal.fire(
                '警告',
                `目前訂單已滿，請稍後再試`,
                'error'
            );
        }
    </script>
@endpush
