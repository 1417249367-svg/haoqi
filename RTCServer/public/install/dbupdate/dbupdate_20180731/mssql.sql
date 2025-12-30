/****** Object:  Table [dbo].[rtc_sms_address]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rtc_sms_address](
	[col_id] [int] IDENTITY(1,1) NOT NULL,
	[col_name] [varchar](50) NULL,
	[col_mobile] [varchar](50) NULL,
	[col_owner] [varchar](50) NULL,
 CONSTRAINT [PK_rtc_sms_address] PRIMARY KEY CLUSTERED 
(
	[col_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_sms_account]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rtc_sms_account](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_account] [varchar](50) NULL,
	[Col_password] [varchar](50) NULL,
	[Col_emp_type] [int] NULL,
	[Col_emp_id] [int] NULL,
	[Col_emp_name] [varchar](255) NULL,
	[Col_Creator_ID] [int] NULL,
	[Col_Creator_Name] [varchar](50) NULL,
	[Col_Dt_Create] [datetime] NOT NULL,
 CONSTRAINT [PK_rtc_sms_account] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_sms]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING OFF
GO
CREATE TABLE [dbo].[rtc_sms](
	[col_id] [int] IDENTITY(1,1) NOT NULL,
	[col_content] [varchar](1024) NULL,
	[col_recv_mobile] [varchar](1024) NULL,
	[col_recv_name] [varchar](4000) NULL,
	[col_send_name] [varchar](50) NULL,
	[col_send_time] [varchar](50) NULL,
	[col_send_url] [text] NULL,
	[col_creator_id] [int] NULL,
	[col_creator_name] [varchar](50) NULL,
	[col_dt_create] [datetime] NOT NULL,
	[col_status] [int] NULL,
	[col_return] [varchar](255) NULL,
	[col_flag] [int] NULL,
	[col_send_loginname] [varchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO


/****** Object:  Table [dbo].[Msg_Acks]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Msg_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
 CONSTRAINT [PK_Msg_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [dbo].[Notice_Acks]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Notice_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsAck1] [int] NULL,
	[IsAck2] [int] NULL,
 CONSTRAINT [PK_Notice_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [dbo].[MessengNotice_Text]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengNotice_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [varchar](255) NULL,
	[MyID] [varchar](50) NULL,
	[YouID] [varchar](50) NULL,
	[Ntitle] [varchar](50) NULL,
	[Ncontent] [varchar](max) NULL,
	[Nlink] [varchar](max) NULL,
	[TO_IP] [varchar](50) NULL,
	[To_Date] [datetime] NULL,
 CONSTRAINT [PK_MessengNotice_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[lv_user]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user](
	[UserId] [nvarchar](50) NOT NULL,
	[UserName] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[RegTime] [datetime] NOT NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[ChatCount] [int] NULL,
	[LastTime] [datetime] NULL,
 CONSTRAINT [PK_lv_user] PRIMARY KEY CLUSTERED 
(
	[UserId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_message]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_message](
	[Id] [int] NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[Note] [nvarchar](1024) NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_message] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_link]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_link](
	[LinkId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[LinkName] [nvarchar](255) NULL,
	[LinkUrl] [nvarchar](255) NULL,
	[LinkType] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_link] PRIMARY KEY CLUSTERED 
(
	[LinkId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_file]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_file](
	[FileId] [int] NOT NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[FileName] [nvarchar](255) NULL,
	[FileSize] [int] NULL,
	[FilePath] [nvarchar](255) NULL,
	[Flag] [int] NULL,
	[CreateUser] [nvarchar](255) NULL,
	[CreateTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_file] PRIMARY KEY CLUSTERED 
(
	[FileId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_ro]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_form]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
 CONSTRAINT [PK_lv_chater_form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [int] NOT NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[DeptName] [nvarchar](50) NULL,
	[JobTitle] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[Mobile] [nvarchar](50) NULL,
	[Picture] [nvarchar](100) NULL,
	[Status] [int] NULL,
	[WelCome] [nvarchar](500) NULL,
	[Reception] [int] NULL,
	[FreeTime] [int] NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_chater] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chat]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chat](
	[ChatId] [int] NOT NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[InTime] [datetime] NULL,
	[ConnectTime] [datetime] NOT NULL,
	[OutTime] [datetime] NULL,
	[Status] [int] NULL,
	[CloseRole] [int] NULL,
	[Rate] [int] NULL,
	[RateNote] [nvarchar](500) NULL,
	[AllowUploadFile] [int] NULL,
	[NContent] [nvarchar](500) NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_chat] PRIMARY KEY CLUSTERED 
(
	[ChatId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [dbo].[Board_Visiter]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Visiter](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[col_BoardID] [varchar](50) NULL,
	[Col_HsItem] [varchar](50) NULL,
	[Col_HsItem_Name] [varchar](50) NULL,
	[col_dt_Create] [datetime] NULL,
	[col_Readed] [int] NULL,
	[col_Dt_Readed] [datetime] NULL,
	[Col_HsItem_ID] [int] NULL,
 CONSTRAINT [PK_Board_Visiter] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Revert]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Revert](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_BoardID] [varchar](50) NULL,
	[Col_Content] [text] NULL,
	[Col_Creator_Id] [int] NOT NULL,
	[Col_Creator_Name] [varchar](50) NULL,
	[Col_Creator] [varchar](50) NULL,
	[Col_Expression] [varchar](200) NULL,
	[Col_Dt_Create] [datetime] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Catalog]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Catalog](
	[col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_Name] [varchar](50) NULL,
	[col_Desc] [text] NULL,
	[col_Order] [int] NULL,
	[col_CompanyId] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Attach]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Attach](
	[col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_BoardID] [varchar](50) NULL,
	[col_FileSize] [int] NULL,
	[col_FilePath] [varchar](255) NULL,
	[col_FileName] [varchar](255) NULL,
	[col_Dt_Create] [datetime] NULL,
	[col_Dt_Modify] [datetime] NULL,
 CONSTRAINT [PK_Board_Attach] PRIMARY KEY CLUSTERED 
(
	[col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board]    Script Date: 08/01/2018 09:35:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Col_ID] [varchar](50) NULL,
	[col_Creator_ID] [int] NULL,
	[col_Creator_Name] [varchar](50) NULL,
	[col_Modifyer_ID] [int] NULL,
	[col_Dt_Modify] [datetime] NULL,
	[col_Subject] [varchar](200) NULL,
	[Col_Content] [text] NULL,
	[Col_AttachmentCount] [int] NULL,
	[Col_ClickCount] [int] NULL,
	[col_Dt_Create] [datetime] NULL,
	[col_Order] [int] NULL,
	[col_G_ClassID] [int] NULL,
	[col_G_ObjID] [int] NULL,
	[col_IsPublic] [int] NULL,
	[col_Creator] [varchar](64) NULL,
	[Col_SenderIP] [varchar](50) NULL,
	[Col_SenderMAC] [varchar](50) NULL,
	[Col_ContentType] [varchar](50) NULL,
	[Col_DataPath] [varchar](max) NULL,
	[Col_CompanyId] [int] NULL,
	[Col_Creator_Dept] [varchar](100) NULL,
	[Col_Creator_DeptId] [int] NULL,
 CONSTRAINT [PK_Board] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO


/****** Object:  Default [DF_Users_ID_Users_IDVesr]    Script Date: 08/01/2018 09:35:45 ******/
ALTER TABLE [dbo].[Users_ID] ADD  [Users_IDVesr]  [int] NULL
GO
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
update [dbo].[Users_ID] set [Users_IDVesr] = 0 where [Users_IDVesr] is null
GO

/****** Object:  Default [DF_Clot_Ro_Users_IDVesr]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  [Users_IDVesr]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
update [dbo].[Clot_Ro] set [Users_IDVesr] = 0 where [Users_IDVesr] is null
GO

ALTER TABLE [dbo].[ClotFile] ADD  [Msg_ID] [varchar](255) NULL
GO
ALTER TABLE [dbo].[LeaveFile] ADD  [Msg_ID] [varchar](255) NULL
GO
ALTER TABLE [dbo].[MessengClot_Text] ADD  [Msg_ID] [varchar](255) NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  [Msg_ID] [varchar](255) NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [Msg_ID] [varchar](255) NULL
GO

/****** Object:  Default [DF_MessengKefu_Text_IsReceipt1]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsReceipt1]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsReceipt1]  DEFAULT ((0)) FOR [IsReceipt1]
GO
update [dbo].[MessengKefu_Text] set [IsReceipt1] = 2 where [IsReceipt1] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsReceipt2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsReceipt2]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
update [dbo].[MessengKefu_Text] set [IsReceipt2] = 2 where [IsReceipt1] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck1]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck1]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck1]  DEFAULT ((0)) FOR [IsAck1]
GO
update [dbo].[MessengKefu_Text] set [IsAck1] = 0 where [IsAck1] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck2]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck2]  DEFAULT ((0)) FOR [IsAck2]
GO
update [dbo].[MessengKefu_Text] set [IsAck2] = 0 where [IsAck2] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck3]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck3]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck3]  DEFAULT ((0)) FOR [IsAck3]
GO
update [dbo].[MessengKefu_Text] set [IsAck3] = 0 where [IsAck3] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck4]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck4]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck4]  DEFAULT ((0)) FOR [IsAck4]
GO
update [dbo].[MessengKefu_Text] set [IsAck4] = 0 where [IsAck4] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck5]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck5]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck5]  DEFAULT ((0)) FOR [IsAck5]
GO
update [dbo].[MessengKefu_Text] set [IsAck5] = 0 where [IsAck5] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck6]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck6]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck6]  DEFAULT ((0)) FOR [IsAck6]
GO
update [dbo].[MessengKefu_Text] set [IsAck6] = 0 where [IsAck6] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck7]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck7]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck7]  DEFAULT ((0)) FOR [IsAck7]
GO
update [dbo].[MessengKefu_Text] set [IsAck7] = 0 where [IsAck7] is null
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck8]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  [IsAck8]  [int] NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck8]  DEFAULT ((0)) FOR [IsAck8]
GO
update [dbo].[MessengKefu_Text] set [IsAck8] = 0 where [IsAck8] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsReceipt1]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsReceipt1]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsReceipt1]  DEFAULT ((0)) FOR [IsReceipt1]
GO
update [dbo].[Messeng_Text] set [IsReceipt1] = 2 where [IsReceipt1] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsReceipt2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsReceipt2]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
update [dbo].[Messeng_Text] set [IsReceipt2] = 2 where [IsReceipt2] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck1]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck1]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck1]  DEFAULT ((0)) FOR [IsAck1]
GO
update [dbo].[Messeng_Text] set [IsAck1] = 0 where [IsAck1] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck2]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck2]  DEFAULT ((0)) FOR [IsAck2]
GO
update [dbo].[Messeng_Text] set [IsAck2] = 0 where [IsAck2] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck3]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck3]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck3]  DEFAULT ((0)) FOR [IsAck3]
GO
update [dbo].[Messeng_Text] set [IsAck3] = 0 where [IsAck3] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck4]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck4]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck4]  DEFAULT ((0)) FOR [IsAck4]
GO
update [dbo].[Messeng_Text] set [IsAck4] = 0 where [IsAck4] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck5]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck5]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck5]  DEFAULT ((0)) FOR [IsAck5]
GO
update [dbo].[Messeng_Text] set [IsAck5] = 0 where [IsAck5] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck6]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck6]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck6]  DEFAULT ((0)) FOR [IsAck6]
GO
update [dbo].[Messeng_Text] set [IsAck6] = 0 where [IsAck6] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck7]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck7]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck7]  DEFAULT ((0)) FOR [IsAck7]
GO
update [dbo].[Messeng_Text] set [IsAck7] = 0 where [IsAck7] is null
GO
/****** Object:  Default [DF_Messeng_Text_IsAck8]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  [IsAck8]  [int] NULL
GO
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck8]  DEFAULT ((0)) FOR [IsAck8]
GO
update [dbo].[Messeng_Text] set [IsAck8] = 0 where [IsAck8] is null
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid1]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid1]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid1]  DEFAULT ((0)) FOR [last_ack_typeid1]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid2]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid2]  DEFAULT ((0)) FOR [last_ack_typeid2]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid3]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid3]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid3]  DEFAULT ((0)) FOR [last_ack_typeid3]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid4]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid4]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid4]  DEFAULT ((0)) FOR [last_ack_typeid4]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid5]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid5]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid5]  DEFAULT ((0)) FOR [last_ack_typeid5]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid6]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid6]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid6]  DEFAULT ((0)) FOR [last_ack_typeid6]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid7]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid7]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid7]  DEFAULT ((0)) FOR [last_ack_typeid7]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid8]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  [last_ack_typeid8]  [int] NULL
GO
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid8]  DEFAULT ((0)) FOR [last_ack_typeid8]
GO

/****** Object:  Default [DF_rtc_SMS_ADDRESS_col_name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_rtc_sms_address_col_name]  DEFAULT ('') FOR [col_name]
GO
/****** Object:  Default [DF_rtc_SMS_ADDRESS_col_mobile]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_rtc_sms_address_col_mobile]  DEFAULT ('') FOR [col_mobile]
GO
/****** Object:  Default [DF_rtc_SMS_ADDRESS_col_owner]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_rtc_sms_address_col_owner]  DEFAULT ('') FOR [col_owner]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_account]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_account]  DEFAULT ('') FOR [Col_account]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_password]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_password]  DEFAULT ('') FOR [Col_password]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_emp_type]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_emp_type]  DEFAULT ((0)) FOR [Col_emp_type]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_emp_id]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_emp_id]  DEFAULT ((0)) FOR [Col_emp_id]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_emp_name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_emp_name]  DEFAULT ('') FOR [Col_emp_name]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_Creator_id]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_Creator_id]  DEFAULT ((0)) FOR [Col_Creator_ID]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_Creator_Name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_Creator_Name]  DEFAULT ('') FOR [Col_Creator_Name]
GO
/****** Object:  Default [DF_rtc_sms_account_Col_Dt_Create]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_rtc_sms_account_Col_Dt_Create]  DEFAULT (getdate()) FOR [Col_Dt_Create]
GO
/****** Object:  Default [DF_rtc_SMS_col_content]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_content]  DEFAULT ('') FOR [col_content]
GO
/****** Object:  Default [DF_rtc_SMS_col_recv_mobile]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_recv_mobile]  DEFAULT ('') FOR [col_recv_mobile]
GO
/****** Object:  Default [DF_rtc_SMS_col_recv_name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_recv_name]  DEFAULT ('') FOR [col_recv_name]
GO
/****** Object:  Default [DF_rtc_SMS_col_send_name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_send_name]  DEFAULT ('') FOR [col_send_name]
GO
/****** Object:  Default [DF_rtc_SMS_col_send_time]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_send_time]  DEFAULT ('') FOR [col_send_time]
GO
/****** Object:  Default [DF_rtc_SMS_col_send_url]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_send_url]  DEFAULT ('') FOR [col_send_url]
GO
/****** Object:  Default [DF_rtc_SMS_col_creator_id]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_creator_id]  DEFAULT ((1)) FOR [col_creator_id]
GO
/****** Object:  Default [DF_rtc_SMS_col_creator_name]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_creator_name]  DEFAULT ('') FOR [col_creator_name]
GO
/****** Object:  Default [DF_rtc_SMS_col_dt_create]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_dt_create]  DEFAULT (getdate()) FOR [col_dt_create]
GO
/****** Object:  Default [DF_rtc_SMS_col_status]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_status]  DEFAULT ((0)) FOR [col_status]
GO
/****** Object:  Default [DF_rtc_SMS_col_return]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_return]  DEFAULT ('') FOR [col_return]
GO
/****** Object:  Default [DF_rtc_SMS_col_flag]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_flag]  DEFAULT ((0)) FOR [col_flag]
GO
/****** Object:  Default [DF_rtc_SMS_col_send_loginname]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_rtc_SMS_col_send_loginname]  DEFAULT ('') FOR [col_send_loginname]
GO
/****** Object:  Default [DF_Notice_Acks_IsReceipt]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_IsReceipt]  DEFAULT ((0)) FOR [IsAck1]
GO
/****** Object:  Default [DF_Notice_Acks_IsReceipt2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_IsReceipt2]  DEFAULT ((0)) FOR [IsAck2]
GO
/****** Object:  Default [DF_Msg_Acks_IsReceipt]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt1]
GO
/****** Object:  Default [DF_Msg_Acks_IsReceipt2]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
/****** Object:  Default [DF_MessengNotice_Text_To_Date]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[MessengNotice_Text] ADD  CONSTRAINT [DF_MessengNotice_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_lv_user_UserId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_user_RegTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_RegTime]  DEFAULT (getdate()) FOR [RegTime]
GO
/****** Object:  Default [DF_lv_user_ChatCount]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_ChatCount]  DEFAULT ((0)) FOR [ChatCount]
GO
/****** Object:  Default [DF_lv_message_Id]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_Id]  DEFAULT ((0)) FOR [Id]
GO
/****** Object:  Default [DF_lv_message_UserId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_message_CreateTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_link_LinkId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_LinkId]  DEFAULT ((0)) FOR [LinkId]
GO
/****** Object:  Default [DF_lv_link_LinkType]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_LinkType]  DEFAULT ((0)) FOR [LinkType]
GO
/****** Object:  Default [DF_lv_link_Ord]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_link_CreateTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_file_FileId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_FileId]  DEFAULT ((0)) FOR [FileId]
GO
/****** Object:  Default [DF_lv_file_GroupId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_file_FileSize]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_FileSize]  DEFAULT ((0)) FOR [FileSize]
GO
/****** Object:  Default [DF_lv_file_Flag]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_file_CreateTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_file_Ord]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_ro_Status]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_Table_1_ItemIndex]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_Table_1_ItemIndex]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_ro_CreateTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_chater_UserId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_chater_Status]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chater_Reception]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Reception]  DEFAULT ((1)) FOR [Reception]
GO
/****** Object:  Default [DF_lv_chater_FreeTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_FreeTime]  DEFAULT ((0)) FOR [FreeTime]
GO
/****** Object:  Default [DF_lv_chater_Ord]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chat_GroupId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chat_UserId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_chat_ConnectTime]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO
/****** Object:  Default [DF_lv_chat_Status]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chat_CloseRole]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO
/****** Object:  Default [DF_lv_chat_Rate]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO
/****** Object:  Default [DF_lv_chat_AllowUploadFile]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO
/****** Object:  Default [DF_lv_chat_Ord]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_Board_Visiter_col_dt_Create]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_col_dt_Create]  DEFAULT (getdate()) FOR [col_dt_Create]
GO
/****** Object:  Default [DF_Board_Visiter_col_Readed]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_col_Readed]  DEFAULT ((0)) FOR [col_Readed]
GO
/****** Object:  Default [DF_Board_Visiter_Col_HsItem_ID]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_Col_HsItem_ID]  DEFAULT ((0)) FOR [Col_HsItem_ID]
GO
/****** Object:  Default [DF_Board_Attach_col_Dt_Create]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board_Attach] ADD  CONSTRAINT [DF_Board_Attach_col_Dt_Create]  DEFAULT (getdate()) FOR [col_Dt_Create]
GO
/****** Object:  Default [DF_Board_col_Creator_ID]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Creator_ID]  DEFAULT ((0)) FOR [col_Creator_ID]
GO
/****** Object:  Default [DF_Board_col_Modifyer_ID]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Modifyer_ID]  DEFAULT ((0)) FOR [col_Modifyer_ID]
GO
/****** Object:  Default [DF_Board_Col_AttachmentCount]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_AttachmentCount]  DEFAULT ((0)) FOR [Col_AttachmentCount]
GO
/****** Object:  Default [DF_Board_Col_ClickCount]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_ClickCount]  DEFAULT ((0)) FOR [Col_ClickCount]
GO
/****** Object:  Default [DF_Board_col_Dt_Create]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Dt_Create]  DEFAULT (getdate()) FOR [col_Dt_Create]
GO
/****** Object:  Default [DF_Board_col_Order]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Order]  DEFAULT ((0)) FOR [col_Order]
GO
/****** Object:  Default [DF_Board_col_G_ClassID]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_G_ClassID]  DEFAULT ((0)) FOR [col_G_ClassID]
GO
/****** Object:  Default [DF_Board_col_G_ObjID]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_G_ObjID]  DEFAULT ((0)) FOR [col_G_ObjID]
GO
/****** Object:  Default [DF_Board_col_IsPublic]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_IsPublic]  DEFAULT ((0)) FOR [col_IsPublic]
GO
/****** Object:  Default [DF_Board_Col_CompanyId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_CompanyId]  DEFAULT ((0)) FOR [Col_CompanyId]
GO
/****** Object:  Default [DF_Board_Col_Creator_DeptId]    Script Date: 08/01/2018 09:35:46 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_Creator_DeptId]  DEFAULT ((0)) FOR [Col_Creator_DeptId]
GO

/****** Object:  Table [dbo].[Plug]    Script Date: 08/01/2018 21:47:30 ******/
SET IDENTITY_INSERT [dbo].[Plug] ON
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (16, N'Online_Service', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:97/?loginname=[UserName]&password=[PassWord]', N'online_service', N'将客服代码复制到网站上，即可实现网站用户与公司指定的客服人员沟通。', N'', N'http://[ServerIp]:98/static/addin/livechat.ico', 1, 9, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (17, N'Board', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/board_list.html?loginname=[UserName]&password=[PassWord]', N'公告', N'公告', N'', N'http://[ServerIp]:98/static/addin/notice.ico', 1, 6, 0)
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (18, N'SMS_List', N'2', N'625', N'1080', N'1', N'http://[ServerIp]:98/addin/sms_list.html?loginname=[UserName]&password=[PassWord]', N'短信', N'短信', N'', N'http://[ServerIp]:98/static/addin/sms.ico', 1, 5, 0)
SET IDENTITY_INSERT [dbo].[Plug] OFF