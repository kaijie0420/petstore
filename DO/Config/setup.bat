@echo off
color BC
echo ���妸�ɸg�g�H�ק�
echo http://kkjs880603.myweb.hinet.net/
echo =================================
echo �iDoDoTSB0T �����ɡj�ƻs�{��
echo.
echo �`�N�I�p�G�z���@�~�t�άOWondows Vista�A�Цb���ɮפW�����u�k��v���u�H�t�κ޲z����������(A)�v�A�Ϧ��妸�ɯ�ƻs�����ɮר�t�θ̭�
echo.
echo ���U���N��}�l�ƻs
pause > nul
echo.
echo ���b�ƻsCOMCAT.DLL
copy COMCAT.DLL %windir%\system32 /Y
echo ���b�ƻsMSCOMCTL.OCX
copy MSCOMCTL.OCX %windir%\system32 /Y
echo ���b�ƻsMSVBVM60.DLL
copy MSVBVM60.DLL %windir%\system32 /Y
echo ���b�ƻsMSWINSCK.OCX
copy MSWINSCK.OCX %windir%\system32 /Y
echo ���b�ƻsRICHED32.DLL
copy RICHED32.DLL %windir%\system32 /Y
echo ���b�ƻsRICHTX32.OCX
copy RICHTX32.OCX %windir%\system32 /Y
echo ���b�ƻsSTDOLE2.TLB
copy STDOLE2.TLB %windir%\system32 /Y
regsvr32 %windir%\system32\COMCAT.DLL /s
regsvr32 %windir%\system32\MSCOMCTL.OCX /s
regsvr32 %windir%\system32\MSVBVM60.DLL /s
regsvr32 %windir%\system32\MSWINSCK.OCX /s
regsvr32 %windir%\system32\RICHED32.DLL /s
regsvr32 %windir%\system32\RICHTX32.OCX /s
echo �ƻs�����I
echo.
echo �Y�O�X�{Windows �ɮ׫O�@���T�������A�Х����u�����v�A�A���u�O(Y)�v
echo.
echo ���U���N�����}
pause > nul