<div id="changeUserPassword">
    @include('livewire.layouts.memberCentreNav')
    <h2>修改密碼</h2>
    @if(session()->has('success'))
            <div class="alert alert-success"> {{session('success')}} </div>
        @endif
    <form wire:submit.prevent='updatePassword' class="info mt-2">
        <table class="table table-bordered table-hover mt-2">
            <thead>
                <tr>
                    <th colspan="2">修改密碼</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>輸入原密碼</td>
                    <td><input type="password" class="form-control"  wire:model='old_password' name="old_password" /></td>
                </tr>
                <tr>
                    <td>輸入新密碼</td>
                    <td><input type="password" class="form-control"  wire:model='password' name="password" /></td>
                </tr>
                <tr>
                    <td>再次確認新密碼</td>
                    <td><input type="password" class="form-control"  wire:model='password_confirmed' name="password_confirmed"  /></td>
                </tr>
            </tbody>
          </table>
          <button class="btn btn-primary" type='submit'>更改密碼</button>
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
