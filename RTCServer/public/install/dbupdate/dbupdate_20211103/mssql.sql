SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER TABLE [dbo].[lv_user] ADD [LoginName] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [TypeID] [nvarchar](50) NULL
GO