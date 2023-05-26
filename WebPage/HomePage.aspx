<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="HomePage.aspx.cs" Inherits="WebPage.HomePage" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="StyleSheet1.css" rel="stylesheet" />
</head>
<body>
    <div class="center">
        <form id="form1" runat="server">
            <div>
                <asp:Label ID="Nametxt" runat="server"></asp:Label><br /><br />
                <asp:Label ID="Label1" runat="server" Text="Filter by Category:"></asp:Label>
                <asp:CheckBoxList ID="CategoryCheck" runat="server" DataSourceID="SqlDataSource2" DataTextField="Category" DataValueField="Category">
                </asp:CheckBoxList>
                <br />
                <asp:SqlDataSource ID="SqlDataSource2" runat="server" ConnectionString="<%$ ConnectionStrings:WebPageDBConnectionString %>" SelectCommand="SELECT DISTINCT [Category] FROM [Products]"></asp:SqlDataSource>
                <asp:Label ID="Label2" runat="server" Text="Filter by Brand:"></asp:Label>
                <asp:CheckBoxList ID="BrandCheck" runat="server" DataSourceID="SqlDataSource3" DataTextField="Brand" DataValueField="Brand">
                </asp:CheckBoxList>
                <asp:Button ID="Button1" runat="server" OnClick="Button1_Click" Text="Filter" Width="67px" />
                <br />
                <asp:SqlDataSource ID="SqlDataSource3" runat="server" ConnectionString="<%$ ConnectionStrings:WebPageDBConnectionString %>" SelectCommand="SELECT DISTINCT [Brand] FROM [Products]"></asp:SqlDataSource>
                <asp:GridView ID="GridView1" runat="server"  AutoGenerateSelectButton="True" AllowSorting="True" OnSorting="GridView1_Sorting" OnSelectedIndexChanged="GridView1_SelectedIndexChanged">
                </asp:GridView>
                <br />
            </div>
        </form>
    </div>
</body>
</html>
