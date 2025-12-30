INSERT [dbo].[Users_Role] ([UserID], [RoleID]) VALUES (N'1', 2);
INSERT [dbo].[Users_Role] ([UserID], [RoleID]) VALUES (N'2', 2);
INSERT [dbo].[Users_Role] ([UserID], [RoleID]) VALUES (N'1', 3);
INSERT [dbo].[Users_Role] ([UserID], [RoleID]) VALUES (N'2', 3);

INSERT [dbo].[Users_Ro] ([TypeID], [TypeName], [ParentID], [Description], [ItemIndex], [CreatorID], [CreatorName]) VALUES (N'000001', N'Finance Department', N'000000', NULL, N'0', N'1', N'admin');

INSERT [dbo].[Users_Pic] ([UserID], [pic], [Sfile]) VALUES (N'1', 3, 0);
INSERT [dbo].[Users_Pic] ([UserID], [pic], [Sfile]) VALUES (N'2', 1, 0);

INSERT [dbo].[Users_ID] ([UppeID], [UserID], [UserName], [UserPaws], [FcName], [Age], [Jod], [Tel1], [Tel2], [Address], [Say], [UserIco], [UserIcoLine], [School], [Effigy], [Constellation], [remark], [Sequence], [binding], [LoginTime], [UserState], [NetworkIP], [LocalIP], [Mac], [Registration_Id], [PlatForm], [ManuFacturer], [LocalIPList], [MacList], [IsVerify], [IsManager], [Fav_FormVesr], [Col_FormVesr], [CreatorID], [CreatorName]) VALUES (N'000001', N'1', N'admin', N'', N'admin', N'', NULL, N'', N'', N'', N'', 1, 0, N'', N'', N'', N'', 0, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, N'1', N'admin');
INSERT [dbo].[Users_ID] ([UppeID], [UserID], [UserName], [UserPaws], [FcName], [Age], [Jod], [Tel1], [Tel2], [Address], [Say], [UserIco], [UserIcoLine], [School], [Effigy], [Constellation], [remark], [Sequence], [binding], [LoginTime], [UserState], [NetworkIP], [LocalIP], [Mac], [Registration_Id], [PlatForm], [ManuFacturer], [LocalIPList], [MacList], [IsVerify], [IsManager], [Fav_FormVesr], [Col_FormVesr], [CreatorID], [CreatorName]) VALUES (N'000001', N'2', N'zhoulin', N'', N'zhoulin', N'20', NULL, N'', N'', N'', N'', 2, 0, N'', N'', N'', N'', 0, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, N'1', N'admin');

INSERT [dbo].[UpDateForm] ([ID], [Users_RoVesr], [Users_IDVesr], [Clot_RoVesr], [Clot_FormVesr], [ClotFile_Vesr], [SecInfoVesr], [Tel_FormVesr], [PtpFile_Vesr], [PtpFolder_Vesr], [PtpForm_Vesr], [LeaveFile_Vesr], [NewGo_Vesr], [NewRo_Vesr], [MyTel_RoVesr], [MyTel_FormVesr], [Plug_Vesr]) VALUES (1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

SET IDENTITY_INSERT [dbo].[Role] ON;
INSERT [dbo].[Role] ([ID], [RoleName], [Description], [Permissions], [Plug], [PtpSize], [PtpType], [PubSize], [PubType], [ClotSize], [ClotType], [UsersSize], [UsersType], [DepartmentPermission], [Department], [SmsCount], [DefaultRole], [CreatorID], [CreatorName]) VALUES (1, N'Staff', N'Staff', N',0,2,3,4,5,6,7,9,10,11,12,14,16,17,18,22,24,25', NULL, 500, N'*', 500, N'*', 500, N'*', 500, N'*', 0, NULL, 100, 1, N'1', N'admin');
INSERT [dbo].[Role] ([ID], [RoleName], [Description], [Permissions], [Plug], [PtpSize], [PtpType], [PubSize], [PubType], [ClotSize], [ClotType], [UsersSize], [UsersType], [DepartmentPermission], [Department], [SmsCount], [DefaultRole], [CreatorID], [CreatorName]) VALUES (2, N'Leadership', N'Leadership', N',0,1,2,3,4,5,6,7,9,10,11,12,14,16,17,18,22,24', NULL, 500, N'*', 500, N'*', 500, N'*', 500, N'*', 0, NULL, 500, 0, N'1', N'admin');
INSERT [dbo].[Role] ([ID], [RoleName], [Description], [Permissions], [Plug], [PtpSize], [PtpType], [PubSize], [PubType], [ClotSize], [ClotType], [UsersSize], [UsersType], [DepartmentPermission], [Department], [SmsCount], [DefaultRole], [CreatorID], [CreatorName]) VALUES (3, N'Administrator', N'Administrator', N',0,1,2,3,4,5,6,7,9,10,11,12,14,16,17,18,21,22,24', NULL, 500, N'*', 500, N'*', 500, N'*', 1000, N'*', 0, NULL, 1000, 0, N'1', N'admin');
SET IDENTITY_INSERT [dbo].[Role] OFF;

SET IDENTITY_INSERT [dbo].[PtpFolder] ON;
INSERT [dbo].[PtpFolder] ([PtpFolderID], [MyID], [UsName], [ParentID], [ToDate], [ToTime], [To_Type], [CreatorID], [CreatorName]) VALUES (1, N'1', N'RTC', N'0', CAST(0x0000A98F00A1CAE9 AS DateTime), CAST(0x0000A98F00A1CAE9 AS DateTime), 3, N'1', N'admin');
INSERT [dbo].[PtpFolder] ([PtpFolderID], [MyID], [UsName], [ParentID], [ToDate], [ToTime], [To_Type], [CreatorID], [CreatorName]) VALUES (2, N'2', N'RTC', N'0', CAST(0x0000A991006D6C8D AS DateTime), CAST(0x0000A991006D6C8D AS DateTime), 3, N'2', N'zhoulin');
SET IDENTITY_INSERT [dbo].[PtpFolder] OFF;


SET IDENTITY_INSERT [dbo].[Plug] ON;
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (1, N'RoamingMessageUrl', N'10', N'600', N'1000', N'1', N'http://[ServerIp]:98/addin/msg_list.html?loginname=[UserName]&chater=[SelUserName]&Token=[Token]', N'RTC_RoamingMessageUrl', N'Message Roaming', NULL, NULL, 1, 0, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (2, N'PushMessageUrl', N'11', N'600', N'1000', N'1', N'http://[ServerIp]:98/addin/push.php', N'RTC_PushMessageUrl', N'Message push', NULL, NULL, 1, 1, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (20, N'Meeting', N'12', N'600', N'1000', N'1', N'', N'RTC_Meeting', N'Real time audio and video', N'https://meeting.rtcim.com', N'', 1, 2, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (18, N'SMS_List', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/sms_list.html?loginname=[UserName]&password=[PassWord]', N'RTC_SMS_List', N'text message', N'', N'http://[ServerIp]:98/static/addin/sms.ico', 1, 3, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (17, N'Board', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/board_list.html?loginname=[UserName]&password=[PassWord]', N'RTC_Board', N'Notice', N'', N'http://[ServerIp]:98/static/addin/notice.ico', 1, 4, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (8, N'OfficeOnlineServer', N'2', N'600', N'800', N'2', N'http://[ServerIp]:98/cloud/include/onlinefile.html?loginname=[UserName]&password=[PassWord]', N'RTC_OfficeOnlineServer', N'Need to deploy an online document server, fill in the parameters (server URL of the online document server, touch point RTC server URL) Considering network speed, it is strongly recommended to deploy an online document server on the intranet..', N'http://127.0.0.1,http://127.0.0.1:98', N'http://[ServerIp]:98/static/addin/onlinefile.ico', 1, 7, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (16, N'Online_Service', N'2', N'868', N'1440', N'1', N'http://[ServerIp]:97/?loginname=[UserName]&password=[PassWord]', N'online_service', N'Copy the customer service code onto the website to enable communication between website users and the designated customer service personnel of the company.', N'', N'http://[ServerIp]:98/static/addin/livechat.ico', 1, 6, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (21, N'CloudDisk', N'2', N'868', N'1440', N'2', N'http://[ServerIp]:98/cloud/include/yunpan.html?loginname=[UserName]&password=[PassWord]', N'RTC_PC_CloudDisk', N'Cloud Drive', N'', N'http://[ServerIp]:98/static/addin/pan.gif', 1, 5, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (5, N'MiniPage', N'2', N'600', N'800', N'1', N'http://www.haoqiniao.cn/', N'RTC_MiniPage', N'Mini webpage', N'', N'http://[ServerIp]:98/static/addin/Corp.ico', 1, 8, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (19, N'phone_CloudDisk', N'7', N'600', N'800', N'3', N'', N'Cloud Drive', N'Cloud Drive', N'', N'http://[ServerIp]:98/static/addin/head2.png', 1, 9, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (22, N'phone_NetDisk', N'7', N'600', N'800', N'3', N'', N'RTC Cloud', N'RTC Cloud', N'', N'http://[ServerIp]:98/static/addin/cloud.png', 1, 10, 0);
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (9, N'phone_OfficeOnlineServer', N'7', N'600', N'800', N'3', N'http://[ServerIp]:98/cloud/include/onlinefile.html?loginname=[UserName]&Token=[Token]', N'Online documents', N'Need to deploy an online document server, fill in the parameters (server URL of the online document server, touch point RTC server URL) Considering network speed, it is strongly recommended to deploy an online document server on the intranet.', N'http://127.0.0.1,http://127.0.0.1:98', N'http://[ServerIp]:98/static/addin/onlinefile.png', 1, 11, 0);
SET IDENTITY_INSERT [dbo].[Plug] OFF;

INSERT [dbo].[OtherForm] ([ID], [Paws], [SUpDate], [WebName], [WebUrl], [WebRun], [Logo], [OneRun], [RuDate], [RuDate1], [RuDate2], [RuDate3], [LastRun], [UpDateTime], [UserApply], [IPAddress], [User_ID], [WebCode], [welcome]) VALUES (1, N'', NULL, N'好奇鸟RTC', N'/', 0, 3, N'BFVgDN4x5j0=', N'aInYhh4R1tY=', N'aInYhh4R1tY=', N'9vR6az1y120=', N'aInYhh4R1tY=', N'iWBdyIuv2VqCEbk3Ixxe/Q==', NULL, 1, N'127.0.0.1:99', N'', N'', N'您好!有什么需要帮忙吗?');

INSERT [dbo].[KefuConfig] ([IPAddress], [User_ID], [WebCode], [welcome]) VALUES (NULL, NULL, NULL, N'您好!有什么需要帮忙吗?');

SET IDENTITY_INSERT [dbo].[jod] ON;
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (1, N'总经理');
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (2, N'部门经理');
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (3, N'部门副经理');
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (4, N'主任');
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (5, N'员工');
INSERT [dbo].[jod] ([ID], [TypeName]) VALUES (6, N'习惯员工');
SET IDENTITY_INSERT [dbo].[jod] OFF;

INSERT [dbo].[Heat_Form] ([UserID], [Type], [LoCoun], [FcName]) VALUES (N'Clot001', 2, N'02', N'内部测试(20)');

SET IDENTITY_INSERT [dbo].[FontForm1] ON;
INSERT [dbo].[FontForm1] ([ID], [FontName], [FontSize], [FontColro], [Bold], [Underline], [Italic]) VALUES (1, N'宋体', 10, N'8388863', 0, 0, 0);
INSERT [dbo].[FontForm1] ([ID], [FontName], [FontSize], [FontColro], [Bold], [Underline], [Italic]) VALUES (2, N'宋体', 10, N'8388863', 0, 0, 0);
SET IDENTITY_INSERT [dbo].[FontForm1] OFF;

SET IDENTITY_INSERT [dbo].[FontForm] ON;
INSERT [dbo].[FontForm] ([ID], [FontName], [FontSize], [FontColro], [Bold], [Underline], [Italic]) VALUES (1, N'宋体', 10, N'8388863', 0, 0, 0);
INSERT [dbo].[FontForm] ([ID], [FontName], [FontSize], [FontColro], [Bold], [Underline], [Italic]) VALUES (2, N'宋体', 10, N'8388863', 0, 0, 0);
SET IDENTITY_INSERT [dbo].[FontForm] OFF;

SET IDENTITY_INSERT [dbo].[Col_Ro] ON;
INSERT [dbo].[Col_Ro] ([TypeID], [TypeName], [ToDate], [ToTime], [MyID]) VALUES (1, N'RTC', CAST(0x0000A83F00000000 AS DateTime), CAST(0xFFFFFFFE011B9350 AS DateTime), N'1');
INSERT [dbo].[Col_Ro] ([TypeID], [TypeName], [ToDate], [ToTime], [MyID]) VALUES (2, N'RTC', CAST(0x0000A83F00000000 AS DateTime), CAST(0xFFFFFFFE011B9800 AS DateTime), N'2');
SET IDENTITY_INSERT [dbo].[Col_Ro] OFF;

INSERT [dbo].[Clot_Ro] ([TypeID], [TypeName], [Remark], [To_Date], [Sender], [UserState], [Disk_Space], [IsPublic], [OwnerID], [ItemIndex], [CreatorID], [CreatorName]) VALUES (N'Clot000002', N'RTC Light office', N'RTC Light office', CAST(0x00009B8C00000000 AS DateTime), 0, 1, N'1024', 0, N'1', N'0', N'1', N'admin');

INSERT [dbo].[Clot_Pic] ([ClotID], [ClotInfo], [pic], [Sfile]) VALUES (N'Clot000002', 0, 0, 0);

INSERT [dbo].[Clot_Form] ([UpperID], [UserID], [IsAdmin], [remark]) VALUES (N'Clot000002', N'2', 1, N'zhoulin');
INSERT [dbo].[Clot_Form] ([UpperID], [UserID], [IsAdmin], [remark]) VALUES (N'Clot000002', N'1', 1, N'admin');

SET IDENTITY_INSERT [dbo].[lv_chater_theme] ON;
INSERT [dbo].[lv_chater_theme] ([TypeID], [GroupId], [TypeName], [Description], [Status], [Ord], [CreateTime]) VALUES (7, 0, N'咨询', N'咨询', 1, 1000, CAST(0x0000AC17016C8AC0 AS DateTime));
INSERT [dbo].[lv_chater_theme] ([TypeID], [GroupId], [TypeName], [Description], [Status], [Ord], [CreateTime]) VALUES (8, 0, N'投诉', N'投诉', 1, 1000, CAST(0x0000AC17016C94A4 AS DateTime));
SET IDENTITY_INSERT [dbo].[lv_chater_theme] OFF;


INSERT [dbo].[lv_user_ro] ([TypeName], [Description], [Status], [Ord]) VALUES (N'潜在客户', N'', 1, 1000);
INSERT [dbo].[lv_user_ro] ([TypeName], [Description], [Status], [Ord]) VALUES (N'日常客户', N'', 1, 1000);
INSERT [dbo].[lv_user_ro] ([TypeName], [Description], [Status], [Ord]) VALUES (N'VIP用户', N'', 1, 1000);
INSERT [dbo].[lv_user_ro] ([TypeName], [Description], [Status], [Ord]) VALUES (N'合作伙伴', N'', 1, 1000);
INSERT [dbo].[lv_user_ro] ([TypeName], [Description], [Status], [Ord]) VALUES (N'失效客户', N'', 1, 1000);


SET IDENTITY_INSERT [dbo].[Col_Ro] ON;
INSERT [dbo].[Col_Ro] ([TypeID], [TypeName], [ToDate], [ToTime], [MyID]) VALUES (3, N'默认', CAST(0x0000AC1D00000000 AS DateTime), CAST(0x000000000174FFE4 AS DateTime), N'Public');
SET IDENTITY_INSERT [dbo].[Col_Ro] OFF;
INSERT [dbo].[Col_Form] ([UpperID], [Title], [NContent], [UsName], [UsID], [TypeS], [MyID]) VALUES (3, N'Welcome to visit our website', N'%u6B22%u8FCE%u8BBF%u95EE%u6211%u4EEC%u7684%u7F51%u7AD9%uFF0C%u6709%u4EC0%u4E48%u53EF%u4EE5%u5E2E%u52A9%u60A8%u5417%3F', NULL, N'2', N'', N'Public');


SET IDENTITY_INSERT [dbo].[Tab_Config] ON
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'RTCServer_IP', N'http://127.0.0.1:98', N'SysConfig', N'', N'', 0, 0, N'', 0, 1);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'Jump_RTCServer_IP', N'http://127.0.0.1:98', N'SysConfig', N'', N'', 0, 0, N'', 0, 71);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'RTC_DATADIR', N'', N'SysConfig', N'', N'', 0, 0, N'', 0, 2);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'RTC_CONSOLE', N'd:/RTCServer/Web/Data', N'SysConfig', N'', N'', 0, 0, N'', 0, 3);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'LOG_LEVEL', N'0', N'SysConfig', N'', N'', 0, 0, N'', 0, 4);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'LOGIN_ERROR_COUNT', N'', N'SysConfig', N'', N'', 0, 0, N'', 0, 5);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'EXPORT_USER_FIELD', N'UserName,FcName,UserIco,Effigy,Tel1,Jod,UserPaws', N'SysConfig', N'', N'', 0, 0, N'', 0, 6);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ACCESS_TOKEN', N'23456', N'SysConfig', N'', N'', 0, 0, N'', 0, 7);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ApiReturnType', N'JSON', N'SysConfig', N'', N'', 0, 0, N'', 0, 8);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'BackOnlineMinute', N'5', N'SysConfig', N'', N'', 0, 0, N'', 0, 9);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'UserApply', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 10);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SMS_PUSH', N'0', N'SysConfig', N'', N'', 0, 0, N'', 0, 11);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SmtpServer', N'smtp.163.com', N'SysConfig', N'', N'', 0, 0, N'', 0, 12);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SmtpPort', N'25', N'SysConfig', N'', N'', 0, 0, N'', 0, 13);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SmtpAccount', N'qiyeim@163.com', N'SysConfig', N'', N'', 0, 0, N'', 0, 14);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SmtpPassword', N'8763250', N'SysConfig', N'', N'', 0, 0, N'', 0, 15);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'EMAIL_PUSH', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 16);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SMS_URL', N'', N'SysConfig', N'', N'', 0, 0, N'', 0, 17);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'LiveChat', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 18);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'OpenPlatForm', N'0', N'SysConfig', N'', N'', 0, 0, N'', 0, 19);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'EnableKeyWord', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 20);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'CustomerServiceMode', N'0', N'SysConfig', N'', N'', 0, 0, N'', 0, 46);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'VerifyUserDevice', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 21);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ipaddress', N'http://127.0.0.1:97', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 22);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'waitTime', N'60', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 23);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'intervalTime', N'45', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 24);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'welcomeText', N'您好,请问有什么可以帮助您?', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 25);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'welcomeType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 63);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'websiteType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 64);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'chaterDistribution', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 65);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'oldVisitorType', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 66);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'oldVisitorTime', N'60', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 67);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'switchType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 26);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'rejectType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 27);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weixinType', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 70);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'cdnType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 72);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'cdnLink', N'cdn.qiyeim.com', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 73);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'dialogType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 74);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'GuestSession', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 75);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'clearHistoryTime', N'12', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 76);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ChatGPTTransferType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 77);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ChatGPTAutoTransferType', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 78);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ChatGPTAutoTransferTime', N'3', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 79);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'InquiryBox', N'1', N'SysConfig', N'', N'', 0, 0, N'', 0, 80);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'beatTime', N'1', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 81);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'Jump_Domain', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 82);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'chaterMode', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 28);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'tokenexpiredtime', N'1558517490', N'PushConfig', N'', N'', 0, 0, N'', 0, 29);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'accesstoken', N'CFzlFvjoM11a76HkhtKKSkhCplrT3sYU7sbBnt2AxaJF1xysnDoLyuec8rRF848mDqOZMjQWTVeIMT2ruk2ofg==', N'PushConfig', N'', N'', 0, 0, N'', 0, 30);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'P2PThreshold', N'0', N'BigAntClientExt', N'', N'', 0, 0, N'', 0, 31);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SyncPushTargetType', N'0', N'AntServerExConfig', N'', N'', 0, 0, N'', 0, 32);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SyncPushLog', N'0', N'AntServerExConfig', N'', N'', 0, 0, N'', 0, 33);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'AntServerFlag', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 34);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'ServerFlagEx', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 35);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'MsgLife', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 36);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'AutoClear', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 37);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'AutoAway', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 38);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'AutoAwayTime', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 39);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'IOSPush', N'0', N'AntServerConfig', N'', N'', 0, 0, N'', 0, 40);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'SyncPushTarget', N'', N'AntAuthenConfig', N'', N'', 0, 0, N'', 0, 41);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'Type', N'0', N'AntAuthenConfig', N'', N'', 0, 0, N'', 0, 42);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'Target', N'', N'AntAuthenConfig', N'', N'', 0, 0, N'', 0, 43);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'TargetReturn', N'JSON', N'AntAuthenConfig', N'', N'', 0, 0, N'', 0, 44);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'domain', N'', N'AntAuthenConfig', N'', N'', 0, 0, N'', 0, 45);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'switchAd', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 51);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'adlink', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 52);

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'switchWeChat', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 53);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_domain', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 54);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_appid', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 55);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_sercet', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 56);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_token', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 57);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_moban_id', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 58);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_subscribe', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 69);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_subscribe_id', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 59);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_subscribe_id2', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 68);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_Mode', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 60);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_customer_service_link', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 61);
INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'weChat_wechat_customer_service_link', N'', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 62);
SET IDENTITY_INSERT [dbo].[Tab_Config] OFF