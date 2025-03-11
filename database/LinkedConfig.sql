select * from LINKEDSV2.chdidong.dbo.chinhanh;
	   UNION ALL
select * from LINKEDSV3.chdidong.dbo.chinhanh;

EXEC sp_linkedservers;

EXEC sp_addlinkedserver 
    @server='LINKEDSV2', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-O2NQEJ35\MSSQLSERVER2';
GO

EXEC sp_addlinkedserver 
    @server='LINKEDSV3', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-O2NQEJ35\MSSQLSERVER3';
GO

EXEC sp_addlinkedserver 
    @server='LINKEDSV4', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-O2NQEJ35\MSSQLSERVER4';
GO

EXEC sp_addlinkedserver 
    @server='MASTER', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-O2NQEJ35';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV2', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',      
    @rmtpassword='13524679';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV3', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',       -- Tài khoản trên server từ xa
    @rmtpassword='13524679';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV4', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',       -- Tài khoản trên server từ xa
    @rmtpassword='13524679';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='MASTER', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',      
    @rmtpassword='13524679';
GO