<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $intros = [
            ["title"=>"安全性", "img"=>"d (1).png" , "text"=>"以全台首座企業级資安監控中心 ( SOC, Security Operation Center) , 提供客戶全年無休的 即時遠端資安監控服務 可協助客戶進行收集 關聯分析及異常網路行為 監控多種重要資安設備 所產生的日誌記錄 如防火牆 入偵測系統、 網頁應用防火牆 防毒軟體系統及AD等。 經由SOC監控人員 專業判讀資安事件時, 實施防禦應變措施 作為客戶資訊安全的管理依據。"],
            ["title"=>"專業性", "img"=>"d (2).png" , "text"=>"維運機構專業人員,與時俱進且主題多元乘著國內外隱私發展趨勢致力於培養個資專業人員視組織之需求透過取得證照的專業人員輔助下提升組織對於個人資料之保護與管理能力,並創造可信賴之個人資料保護及隱私環境提升資料創新能力,建構數位轉型基礎。"],
            ["title"=>"穩定性", "img"=>"d (3).png" , "text"=>"對於穩定性技術RAS有更多、更高的要求,也會需要使用帶有糾錯功能的ECC記憶體另外伺服器的硬碟也會做raid備份資料,在故障排除時更換硬體,讓伺服器成為更可靠的選擇。"],
            ["title"=>"保障性", "img"=>"d (4).png" , "text"=>"現代化伺服器搭載 Windows Server 2023 這是一種雲端就緒作業系統, 可透過多層安全性保護、 獨特的混合功能、 靈活的遠端辦公特點, 以及現代化應用程式的增強功能 都能夠最大化您的現有投資。"],
        ];
        return view('livewire.home-component', ['intros'=>$intros])->layout('livewire.layouts.base');
    }
}
