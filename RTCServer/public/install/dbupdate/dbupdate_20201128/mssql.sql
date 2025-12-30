SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


ALTER TABLE [dbo].[MessengKefu_Text] ALTER COLUMN [MyID] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[MessengKefu_Text] ALTER COLUMN [YouID] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_transfer] ALTER COLUMN [MyID] [nvarchar](50) NULL
GO
ALTER TABLE [dbo].[lv_transfer] ALTER COLUMN [YouID] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [IsWeiXin] [tinyint] NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [subscribe] [tinyint] NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [sex] [tinyint] NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [language] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [city] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [province] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [country] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [headimgurl] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD [privilege] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_IsWeiXin]  DEFAULT ((0)) FOR [IsWeiXin]
GO

ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_subscribe]  DEFAULT ((0)) FOR [subscribe]
GO

ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_sex]  DEFAULT ((0)) FOR [sex]
GO

ALTER TABLE [dbo].[Users_ID] ADD [ExpireTime] [bigint] NULL
GO

ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_ExpireTime]  DEFAULT ((0)) FOR [ExpireTime]
GO