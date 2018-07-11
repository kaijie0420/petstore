@echo off
color BC
echo 此批次檔經狂人修改
echo http://kkjs880603.myweb.hinet.net/
echo =================================
echo 【DoDoTSB0T 必備檔】複製程式
echo.
echo 注意！如果您的作業系統是Wondows Vista，請在此檔案上面按「右鍵」→「以系統管理員身分執行(A)」，使此批次檔能複製相關檔案到系統裡面
echo.
echo 按下任意鍵開始複製
pause > nul
echo.
echo 正在複製COMCAT.DLL
copy COMCAT.DLL %windir%\system32 /Y
echo 正在複製MSCOMCTL.OCX
copy MSCOMCTL.OCX %windir%\system32 /Y
echo 正在複製MSVBVM60.DLL
copy MSVBVM60.DLL %windir%\system32 /Y
echo 正在複製MSWINSCK.OCX
copy MSWINSCK.OCX %windir%\system32 /Y
echo 正在複製RICHED32.DLL
copy RICHED32.DLL %windir%\system32 /Y
echo 正在複製RICHTX32.OCX
copy RICHTX32.OCX %windir%\system32 /Y
echo 正在複製STDOLE2.TLB
copy STDOLE2.TLB %windir%\system32 /Y
regsvr32 %windir%\system32\COMCAT.DLL /s
regsvr32 %windir%\system32\MSCOMCTL.OCX /s
regsvr32 %windir%\system32\MSVBVM60.DLL /s
regsvr32 %windir%\system32\MSWINSCK.OCX /s
regsvr32 %windir%\system32\RICHED32.DLL /s
regsvr32 %windir%\system32\RICHTX32.OCX /s
echo 複製完成！
echo.
echo 若是出現Windows 檔案保護的訊息視窗，請先按「取消」，再按「是(Y)」
echo.
echo 按下任意鍵離開
pause > nul