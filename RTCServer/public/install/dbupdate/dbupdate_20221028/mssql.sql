/****** Object:  Table [dbo].[MD5BigFile]    Script Date: 10/29/2022 23:33:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[MD5BigFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [varchar](10) NULL,
	[FormFileType] [smallint] NULL,
	[TypePath] [varchar](255) NULL,
	[PcSize] [varchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [varchar](200) NULL,
	[BlobNum] [int] NULL,
	[Context] [varchar](200) NULL,
 CONSTRAINT [PK_BigFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_FormFileType]  DEFAULT ((0)) FOR [FormFileType]
GO

ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO

ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO

ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_BlobNum]  DEFAULT ((0)) FOR [BlobNum]
GO

/****** Object:  Table [dbo].[MD5VideoFile]    Script Date: 11/03/2022 15:13:32 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[MD5VideoFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [varchar](10) NULL,
	[FormFileType] [smallint] NULL,
	[TypePath] [varchar](255) NULL,
	[PcSize] [varchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [varchar](200) NULL,
	[Context] [varchar](200) NULL,
 CONSTRAINT [PK_MD5VideoFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_FormFileType]  DEFAULT ((0)) FOR [FormFileType]
GO

ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO

ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO

/****** Object:  Table [dbo].[lv_user_reception]    Script Date: 02/20/2023 10:47:50 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[lv_user_reception](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [varchar](50) NOT NULL,
	[YouID] [varchar](50) NOT NULL,
	[Ncontent] [varchar](8000) NULL,
	[TO_IP] [varchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
	[ChaterReception] [int] NULL,
	[Chater_RoReception] [int] NULL,
	[DefaultReception] [int] NULL,
 CONSTRAINT [PK_lv_user_reception] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_TO_Date]  DEFAULT (getdate()) FOR [TO_Date]
GO

ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO

ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_ChaterReception]  DEFAULT ((0)) FOR [ChaterReception]
GO

ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_Chater_roReception]  DEFAULT ((0)) FOR [Chater_RoReception]
GO

ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO

ALTER TABLE [dbo].[lv_user] ADD [OtherTitle] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [OtherUrl] [nvarchar](500) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID1] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID2] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID3] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID4] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID5] [int] NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID6] [int] NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID7] [int] NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID8] [int] NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID9] [nvarchar](500) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [cookieHCID10] [nvarchar](500) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID5]  DEFAULT ((0)) FOR [cookieHCID5]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID6]  DEFAULT ((0)) FOR [cookieHCID6]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID7]  DEFAULT ((0)) FOR [cookieHCID7]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID8]  DEFAULT ((0)) FOR [cookieHCID8]
GO

ALTER TABLE [dbo].[lv_chater] ADD [DefaultReception] [int] NULL
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO
ALTER TABLE [dbo].[lv_chater_ro] ADD [DefaultReception] [int] NULL
GO
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO