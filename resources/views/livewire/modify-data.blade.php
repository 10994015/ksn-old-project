<div id="modifyData">
    @include('livewire.layouts.memberCentreNav')
    <h2>修改會員資料</h2>
    <div class="info mt-2">
        <table class="table table-bordered table-hover mt-2">
            <thead>
                <tr>
                    <th colspan="2">修改資料</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>會員帳號</td>
                    <td><input type="text" class="form-control" disabled wire:model='username' /></td>
                </tr>
                <tr>
                    <td>會員名稱</td>
                    <td>
                        @if(session()->has('message'))
                            <div class="alert alert-success"> {{session('message')}} </div>
                        @endif
                        <input type="text" class="form-control"  wire:model='name' />
                        <button class="btn btn-primary mt-2" wire:click='updateName'>更改</button>
                    </td>
                </tr>
                <tr>
                    <td>手機號碼</td>
                    <td><input type="text" class="form-control" disabled wire:model='phone' /></td>
                </tr>
                <tr>
                    <td colspan="2"><a href="/changeUserPassword" class="btn btn-primary">更改密碼</a></td>
                </tr>
            </tbody>
          </table>
    </div>
</div>
