SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER TABLE [dbo].[lv_chater_ro] ADD [To_Type] [smallint] NULL
GO
ALTER TABLE [dbo].[lv_user_ro] ADD [To_Type] [smallint] NULL
GO

ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO

ALTER TABLE [dbo].[lv_chater] ADD [DefaultTargetLanguage] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD [UserAutoTranslate] [int] NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD [UserTargetLanguage] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD [ChaterAutoTranslate] [int] NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD [ChaterTargetLanguage] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD [EndSession] [int] NULL
GO

ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_DefaultTargetLanguage]  DEFAULT (N'en') FOR [DefaultTargetLanguage]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserAutoTranslate]  DEFAULT ((0)) FOR [UserAutoTranslate]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserTargetLanguage]  DEFAULT (N'en') FOR [UserTargetLanguage]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_ChaterAutoTranslate]  DEFAULT ((0)) FOR [ChaterAutoTranslate]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_ChaterTargetLanguage]  DEFAULT (N'en') FOR [ChaterTargetLanguage]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_EndSession]  DEFAULT ((0)) FOR [EndSession]
GO

ALTER TABLE [dbo].[Msg_Acks] ADD [To_Date] [datetime] NULL
GO
ALTER TABLE [dbo].[Msg_Acks] ADD [To_Time] [datetime] NULL
GO

ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO

/****** Object:  Table [dbo].[lv_chater_Clot_Ro]    Script Date: 07/01/2022 13:02:04 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[lv_chater_Clot_Ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[PID] [int] NULL,
	[UserId] [nvarchar](50) NULL,
	[TypeName] [varchar](200) NULL,
	[Remark] [varchar](max) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[To_Date] [datetime] NULL,
	[Sender] [int] NULL,
	[UserState] [int] NULL,
	[Disk_Space] [varchar](50) NULL,
	[IsPublic] [int] NULL,
	[OwnerID] [varchar](50) NULL,
	[ItemIndex] [varchar](50) NULL,
	[CreatorID] [varchar](50) NULL,
	[CreatorName] [varchar](200) NULL,
	[Users_IDVesr] [int] NULL,
	[Users_FormVesr] [int] NULL,
 CONSTRAINT [PK_lv_chater_Clot_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Sender]  DEFAULT ((0)) FOR [Sender]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_UserState]  DEFAULT ((0)) FOR [UserState]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_DiskSpace]  DEFAULT ((1024)) FOR [Disk_Space]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_IsPublic]  DEFAULT ((0)) FOR [IsPublic]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_OwnerID]  DEFAULT ((1)) FOR [OwnerID]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_ItemIndex]  DEFAULT ((0)) FOR [ItemIndex]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Users_FormVesr]  DEFAULT ((0)) FOR [Users_FormVesr]
GO

/****** Object:  Table [dbo].[lv_chater_Clot_Form]    Script Date: 07/01/2022 13:03:03 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[lv_chater_Clot_Form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[PID] [int] NULL,
	[TypeID] [int] NOT NULL,
	[UserID] [varchar](50) NOT NULL,
	[IsAdmin] [tinyint] NULL,
	[remark] [varchar](255) NULL,
	[last_ack_typeid1] [int] NULL,
	[last_ack_typeid2] [int] NULL,
	[last_ack_typeid3] [int] NULL,
	[last_ack_typeid4] [int] NULL,
	[last_ack_typeid5] [int] NULL,
	[last_ack_typeid6] [int] NULL,
	[last_ack_typeid7] [int] NULL,
	[last_ack_typeid8] [int] NULL,
 CONSTRAINT [PK_lv_chater_Clot_Form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid1]  DEFAULT ((0)) FOR [last_ack_typeid1]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid2]  DEFAULT ((0)) FOR [last_ack_typeid2]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid3]  DEFAULT ((0)) FOR [last_ack_typeid3]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid4]  DEFAULT ((0)) FOR [last_ack_typeid4]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid5]  DEFAULT ((0)) FOR [last_ack_typeid5]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid6]  DEFAULT ((0)) FOR [last_ack_typeid6]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid7]  DEFAULT ((0)) FOR [last_ack_typeid7]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid8]  DEFAULT ((0)) FOR [last_ack_typeid8]
GO

/****** Object:  Table [dbo].[MessengKefuClot_Text]    Script Date: 07/01/2022 13:03:39 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[MessengKefuClot_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [varchar](255) NULL,
	[ClotID] [varchar](20) NULL,
	[MyID] [varchar](50) NULL,
	[YouID] [varchar](50) NULL,
	[FcName] [varchar](500) NULL,
	[To_Type] [smallint] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [varchar](max) NULL,
	[FontInfo] [varchar](50) NULL,
 CONSTRAINT [PK_MessengKefuClot_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO

ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO

/****** Object:  Table [dbo].[lv_chater_KefuMsg_Acks]    Script Date: 07/01/2022 13:04:17 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[lv_chater_KefuMsg_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
 CONSTRAINT [PK_KefuMsg_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_KefuMsg_Acks_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt1]
GO

ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_KefuMsg_Acks_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO

ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_lv_chater_KefuMsg_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_lv_chater_KefuMsg_Acks_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO


update lv_chater_ro set To_Type=0
update lv_user_ro set To_Type=0