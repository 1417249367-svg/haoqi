/****** Object:  Table [dbo].[rtc_keyword]    Script Date: 01/10/2019 21:38:23 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[rtc_keyword](
	[col_id] [varchar](50) NOT NULL,
	[col_type] [int] NOT NULL,
	[col_keyword] [varchar](1024) NOT NULL,
	[col_date] [varchar](20) NULL,
 CONSTRAINT [PK_ant_keyword] PRIMARY KEY CLUSTERED 
(
	[col_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_type]  DEFAULT ((0)) FOR [col_type]
GO

ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_keyword]  DEFAULT ('') FOR [col_keyword]
GO

ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_date]  DEFAULT ('') FOR [col_date]
GO

ALTER TABLE [dbo].[Users_ID] ADD  [ManuFacturer]  [varchar](50) NULL
GO

update Plug set Plug_Target='http://[ServerIp]:98/addin/push.php' where Plug_Name='PushMessageUrl'
update Plug set Plug_TargetType=2,Plug_Target='http://[ServerIp]:98/cloud/include/onlinefile.html?loginname=[UserName]&password=[PassWord]' where Plug_Name='OfficeOnlineServer'