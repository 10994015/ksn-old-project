<div id="ticket-order">
    <div class="service">
        <div class="content">
            <div class="viewImg">
                @for ($i=1;$i<=10;$i++)
                <img src="/ksn/images/orders/{{$i}}.png" onclick="warning()">
                @endfor
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const btnList = document.getElementById('btnList')
        const viewImg = document.getElementById('viewImg')
        const toggleViewImg = (e)=>{
            console.log();
            viewImg.src = "/images/" + e.target.value + ".png"
        }
        const warning = ()=>{
            Swal.fire(
                '警告',
                `目前訂單已滿，請稍後再試`,
                'error'
            );
        }
        for(let i=0;i<btnList.querySelectorAll('.btnItem').length;i++){
            btnList.querySelectorAll('.btnItem')[i].addEventListener('mouseover', toggleViewImg);
            btnList.querySelectorAll('.btnItem')[i].addEventListener('click', warning);
        }
    </script>
@endpush
