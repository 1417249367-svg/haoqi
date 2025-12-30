SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[lv_user] ADD  [QQ] [varchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  [WeChat] [varchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  [Remarks] [varchar](500) NULL
GO

ALTER TABLE [dbo].[Clot_Form] ADD  [id] [int] IDENTITY(1,1) NOT NULL
GO

/****** Object:  Table [dbo].[lv_track]    Script Date: 05/05/2020 00:04:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_track](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[SourceId] [nvarchar](50) NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TrackUrl] [nvarchar](500) NULL,
	[Flag] [int] NULL,
	[InTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_track] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_source]    Script Date: 05/05/2020 00:04:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_source](
	[SourceId] [int] IDENTITY(1,1) NOT NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[SourceUrl] [nvarchar](500) NULL,
	[LaunchUrl] [nvarchar](500) NULL,
	[KeyWord] [nvarchar](255) NULL,
	[Flag] [int] NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[Browser] [nvarchar](50) NULL,
	[InTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_source] PRIMARY KEY CLUSTERED 
(
	[SourceId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_quicktalk]    Script Date: 05/05/2020 00:04:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_quicktalk](
	[TalkId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[Subject] [nvarchar](255) NULL,
	[UserText] [varchar](max) NULL,
	[To_Type] [smallint] NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_quick_talk] PRIMARY KEY CLUSTERED 
(
	[TalkId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_user_ro]    Script Date: 05/05/2020 00:04:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user_ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_user_ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_user_form]    Script Date: 05/05/2020 00:04:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user_form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
 CONSTRAINT [PK_lv_user_form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Default [DF_lv_track_GroupId]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_track_Flag]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_track_CreateTime]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_CreateTime]  DEFAULT (getdate()) FOR [InTime]
GO
/****** Object:  Default [DF_lv_track_Ord]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_source_GroupId]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_source_Flag]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_source_CreateTime]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_CreateTime]  DEFAULT (getdate()) FOR [InTime]
GO
/****** Object:  Default [DF_lv_source_Ord]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_quick_talk_TalkId]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_TalkId]  DEFAULT ((0)) FOR [TalkId]
GO
/****** Object:  Default [DF_lv_quick_talk_To_Type]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_quick_talk_Status]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_quick_talk_Ord]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_quick_talk_CreateTime]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_user_ro_Status]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_user_ro_Ord]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_user_ro_CreateTime]    Script Date: 05/05/2020 00:04:01 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO