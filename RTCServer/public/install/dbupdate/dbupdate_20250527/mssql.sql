/****** Object:  Table [dbo].[MD5BigFile]    Script Date: 10/29/2022 23:33:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[lv_chater_wechat] ADD [Description1] [nvarchar](500) NULL
GO
ALTER TABLE [dbo].[lv_chater_wechat] ADD [domain1] [nvarchar](200) NULL
GO
ALTER TABLE [dbo].[lv_chater_wechat] ADD [appid1] [nvarchar](200) NULL
GO
ALTER TABLE [dbo].[lv_chater_wechat] ADD [sercet1] [nvarchar](200) NULL
GO
ALTER TABLE [dbo].[lv_chater_wechat] ADD [moban_id1] [nvarchar](200) NULL
GO

ALTER TABLE [dbo].[MessengKefuClot_Text] ADD [PID] [int] NULL
GO
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD [TypeName] [nvarchar](500) NULL
GO
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD [Picture] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[MessengKefu_Text] ADD [Picture] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[MessengKefu_Text] ALTER COLUMN [FcName] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[lv_chater_ro] ALTER COLUMN [TypeName] [nvarchar](500) NULL
GO

ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_PID]  DEFAULT ((0)) FOR [PID]
GO

ALTER TABLE [dbo].[lv_user_form] ADD [To_Type] [int] NULL
GO

ALTER TABLE [dbo].[lv_user_form] ADD [MyID] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user_form] ADD  CONSTRAINT [DF_lv_user_form_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO