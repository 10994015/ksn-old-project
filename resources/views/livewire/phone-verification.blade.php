<div id="phoneVer" wire:ignore>
    <style>
        .disabled{
            background-color: #aaa;
        }
        #timeout{
            display: none
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center flex-column" style="width:350px">
        <h5 class="text-light mb-5">您尚未進行手機驗證，請先進行驗證</h5>
        <button wire:click='sendCode' class="btn btn-primary mb-2" id="sendCodeBtn" >發送驗證碼</button>
        <p class="text-light mb-4" id="timeout">120s後重新發送驗證碼</p>
        <input type="text" class="form-control" wire:model='code' class="input-code">
        <button class="btn btn-success mt-3" id="verBtn" >進行驗證</button>
    </div>
    
</div>

@push('scripts')
<script>
    sendCodeBtn.addEventListener('click', e=>{
        let tNum = 120;
        timeout.style.display = "block";
        sendCodeBtn.disabled = true;
        sendCodeBtn.innerText = "重新發送驗證碼";
        sendCodeBtn.classList.add('btn-secondary');
        sendCodeBtn.classList.remove('btn-primary');
        setTimeout(() => {
            sendCodeBtn.disabled = false;
            sendCodeBtn.classList.remove('btn-secondary');
            sendCodeBtn.classList.add('btn-primary');
        }, 120000);
        setInterval(()=>{
            tNum--;
            timeout.innerHTML = `${tNum}s後重新發送驗證碼`;
            if(tNum === 0){
                timeout.style.display = "none";
            }
        }, 1000)
    })
    window.addEventListener('verificationFailFn', e=>{
        alert('驗證失敗!')
    });
    window.addEventListener('verificationSuccessFn', e=>{
        alert('驗證成功!');
        window.location.href = "/";
    });
    verBtn.addEventListener('click', ()=>{
        window.Livewire.emit('verification');
    })
</script>

@endpush