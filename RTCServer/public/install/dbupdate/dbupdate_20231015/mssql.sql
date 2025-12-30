/****** Object:  Table [dbo].[MD5BigFile]    Script Date: 10/29/2022 23:33:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

INSERT [dbo].[Tab_Config] ([Col_Name], [Col_Data], [Col_Genre], [col_AntServer], [col_LoginName], [col_HsItemID], [col_HsItemType], [Col_PackageName], [Col_Disabled], [Col_ID]) VALUES (N'Jump_Domain', N'0', N'LivechatConfig', N'', N'', 0, 0, N'', 0, 82)

ALTER TABLE [dbo].[PtpFolder] ALTER COLUMN [UsName] [varchar](512) NULL
GO
ALTER TABLE [dbo].[PtpFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[PtpFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[OnlineRevisedFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[OnlineRevisedFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[OnlineFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[OnlineFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5File] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5File] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5BigFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5BigFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5VideoFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[MD5VideoFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[LeaveFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[LeaveFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[DownLoad] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[ClotFile] ALTER COLUMN [TypePath] [varchar](512) NULL
GO
ALTER TABLE [dbo].[ClotFile] ALTER COLUMN [FilPath] [varchar](512) NULL
GO