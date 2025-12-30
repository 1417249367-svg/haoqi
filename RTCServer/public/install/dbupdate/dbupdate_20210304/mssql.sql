SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

/****** Object:  Table [dbo].[lv_chater_form]    Script Date: 03/08/2021 14:39:07 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[lv_chater_notice](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
 CONSTRAINT [PK_lv_chater_notice] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

delete from Plug where Plug_Site='2'

SET IDENTITY_INSERT [dbo].[Plug] ON
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (18, N'SMS_List', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/sms_list.html?loginname=[UserName]&password=[PassWord]', N'RTC_SMS_List', N'短信', N'', N'http://[ServerIp]:98/static/addin/sms.ico', 1, 3, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (17, N'Board', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/board_list.html?loginname=[UserName]&password=[PassWord]', N'RTC_Board', N'公告', N'', N'http://[ServerIp]:98/static/addin/notice.ico', 1, 4, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (8, N'OfficeOnlineServer', N'2', N'600', N'800', N'2', N'http://[ServerIp]:98/cloud/include/onlinefile.html?loginname=[UserName]&password=[PassWord]', N'RTC_OfficeOnlineServer', N'服务器如果能连外网，需要做端口映射，参数那里填(http://docx.qiyeim.com,外网网址),如果不能连外网,需要在内网部署在线文档服务器，参数那里填(在线文档服务器的服务器网址,触点通RTC服务器网址).考虑到网速,强烈建议内网部署在线文档服务器.', N'http://127.0.0.1,http://127.0.0.1:98', N'http://[ServerIp]:98/static/addin/onlinefile.ico', 1, 5, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (16, N'Online_Service', N'2', N'868', N'1440', N'1', N'http://[ServerIp]:97/?loginname=[UserName]&password=[PassWord]', N'online_service', N'将客服代码复制到网站上，即可实现网站用户与公司指定的客服人员沟通。', N'', N'http://[ServerIp]:98/static/addin/livechat.ico', 1, 6, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (21, N'CloudDisk', N'2', N'868', N'1440', N'2', N'http://[ServerIp]:98/cloud/include/yunpan.html?loginname=[UserName]&password=[PassWord]', N'RTC_PC_CloudDisk', N'云盘', N'', N'http://[ServerIp]:98/static/addin/pan.gif', 1, 7, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (5, N'MiniPage', N'2', N'600', N'800', N'1', N'http://www.haoqiniao.cn/', N'RTC_MiniPage', N'迷你网页', N'', N'http://[ServerIp]:98/static/addin/Corp.ico', 1, 8, 0)
SET IDENTITY_INSERT [dbo].[Plug] OFF