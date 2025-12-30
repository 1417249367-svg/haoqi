/****** Object:  Table [dbo].[MD5BigFile]    Script Date: 10/29/2022 23:33:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[OnlineFile] ADD [Authority3] [int] NULL
GO
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_Authority3]  DEFAULT ((1)) FOR [Authority3]
GO

ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD [To_Date] [datetime] NULL
GO
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

ALTER TABLE [dbo].[Notice_Acks] ADD [To_Date] [datetime] NULL
GO
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO

update OnlineFile set Authority3=1
update lv_chater_Clot_Form set To_Date=getdate()
update Notice_Acks set To_Date=getdate()