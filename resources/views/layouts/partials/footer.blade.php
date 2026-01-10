  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> {{ \App\Models\SaasSetting::where('key', 'app_version')->value('value') ?? '1.0.0' }}
    </div>
    <strong>Copyright &copy; {{ date('Y') }} 
        {{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'KopDes Digital' }}
    .</strong> All rights reserved.
  </footer>
