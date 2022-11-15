package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.List;

import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;

import bean.UserBean;

public class UserBeanDao {
	public static boolean getUserId(String login_id){
		Connection con = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			String sql = "SELECT COUNT(*) AS cnt FROM users WHERE login_id=?";
			ps = con.prepareStatement(sql);
			ps.setString(1, login_id);
			rs = ps.executeQuery();
			int count = -1;

			if (rs.next()) {
				count = rs.getInt("cnt");
			}
			if (count == 1) {
				return false;
			}else {
				return true;
			}
		}catch(Exception ex) {
			System.err.println(ex.getMessage());
			return false;
		}finally {
			try {
				if(rs != null) {
					rs.close();
				}
				if(ps != null) {
					ps.close();
				}
				if(con != null) {
					con.close();
				}
			}catch(Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
	}
	public static boolean addAccount(UserBean account){
		Connection con = null;
		PreparedStatement ps = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			String sql = "INSERT INTO users(login_id,password,l_name,f_name,l_name_kana,f_name_kana,tel,email)VALUES(?,SHA2(?,256),?,?,?,?,?,?)";
			ps = con.prepareStatement(sql);
			ps.setString(1, account.getLoginId());
			ps.setString(2, account.getPassword());
			ps.setString(3, account.getLName());
			ps.setString(4, account.getFName());
			ps.setString(5, account.getLNameKana());
			ps.setString(6, account.getFNameKana());
			ps.setString(7, account.getTel());
			ps.setString(8, account.getEmail());
			int ret = ps.executeUpdate();

			if (ret != 0) {
				return true;
			}else {
				return false;
			}

		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return false;
		} finally {
			try {

				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
	}
	public static List<UserBean> getLogin(String login_id, String password){
		List<UserBean> list = new ArrayList<UserBean>();
		Connection con = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			ps = con.prepareStatement("SELECT * FROM users WHERE (login_id=? AND password=SHA2(?,256) AND flg=0)");
			ps.setString(1, login_id);
			ps.setString(2, password);
			rs = ps.executeQuery();

			while(rs.next()) {
				int id = rs.getInt("id");
				String loginid = rs.getString("login_id");
				UserBean login = new UserBean(id, loginid);
				list.add(login);
			}
		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return null;
		} finally {
			try {
				if (rs != null) {
					rs.close();
				}
				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
		return list;
	}
	public static List<UserBean> getListByUser(){
		List<UserBean> list = new ArrayList<UserBean>();
		Connection con = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			ps = con.prepareStatement("SELECT * FROM users");
			rs = ps.executeQuery();

			while(rs.next()) {
				int id = rs.getInt("id");
				String loginid = rs.getString("login_id");
				String password = rs.getString("password");
				String l_name = rs.getString("l_name");
				String f_name = rs.getString("f_name");
				String l_name_kana = rs.getString("l_name_kana");
				String f_name_kana = rs.getString("f_name_kana");
				String tel = rs.getString("tel");
				String email = rs.getString("email");
				String other = rs.getString("other");
				int flg = rs.getInt("flg");
				UserBean userList = new UserBean(id,loginid,password,l_name,f_name,l_name_kana,f_name_kana,tel,email,other,flg);
				list.add(userList);
			}
		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return null;
		} finally {
			try {
				if (rs != null) {
					rs.close();
				}
				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
		return list;
	}
	public static List<UserBean> getId(int user_id){
		List<UserBean> list2 = new ArrayList<UserBean>();
		Connection con = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			ps = con.prepareStatement("SELECT * FROM users WHERE id=?");
			ps.setInt(1, user_id);
			rs = ps.executeQuery();

			while(rs.next()) {
				int id = rs.getInt("id");
				String loginid = rs.getString("login_id");
				String password = rs.getString("password");
				String l_name = rs.getString("l_name");
				String f_name = rs.getString("f_name");
				String l_name_kana = rs.getString("l_name_kana");
				String f_name_kana = rs.getString("f_name_kana");
				String tel = rs.getString("tel");
				String email = rs.getString("email");
				String other = rs.getString("other");
				int flg = rs.getInt("flg");
				UserBean user = new UserBean(id,loginid,password,l_name,f_name,l_name_kana,f_name_kana,tel,email,other,flg);
				list2.add(user);
			}
		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return null;
		} finally {
			try {
				if (rs != null) {
					rs.close();
				}
				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
		return list2;
	}
	public static boolean updateAccountRevise(UserBean account_revise){
		Connection con = null;
		PreparedStatement ps = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			String sql = "UPDATE users SET login_id=?,password=SHA2(?,256),l_name=?,f_name=?,l_name_kana=?,f_name_kana=?,tel=?,email=?,other=? WHERE id=?";
			ps = con.prepareStatement(sql);
			ps.setString(1, account_revise.getLoginId());
			ps.setString(2, account_revise.getPassword());
			ps.setString(3, account_revise.getLName());
			ps.setString(4, account_revise.getFName());
			ps.setString(5, account_revise.getLNameKana());
			ps.setString(6, account_revise.getFNameKana());
			ps.setString(7, account_revise.getTel());
			ps.setString(8, account_revise.getEmail());
			ps.setString(9, account_revise.getOther());
			ps.setInt(10, account_revise.getId());
			int ret = ps.executeUpdate();

			if (ret != 0) {
				return true;
			}else {
				return false;
			}

		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return false;
		} finally {
			try {

				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
	}
	public static boolean AccountDelete(int id){
		Connection con = null;
		PreparedStatement ps = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			String sql = "UPDATE users SET flg=? WHERE id=?";
			ps = con.prepareStatement(sql);
			ps.setString(1, "1");
			ps.setInt(2, id);
			int ret = ps.executeUpdate();

			if (ret != 0) {
				return true;
			}else {
				return false;
			}

		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return false;
		} finally {
			try {

				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
	}
	public static boolean addAccountRegister(UserBean account_register){
		Connection con = null;
		PreparedStatement ps = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			String sql = "INSERT INTO users(login_id,password,l_name,f_name,l_name_kana,f_name_kana,tel,email,other)VALUES(?,SHA2(?,256),?,?,?,?,?,?,?)";
			ps = con.prepareStatement(sql);
			ps.setString(1, account_register.getLoginId());
			ps.setString(2, account_register.getPassword());
			ps.setString(3, account_register.getLName());
			ps.setString(4, account_register.getFName());
			ps.setString(5, account_register.getLNameKana());
			ps.setString(6, account_register.getFNameKana());
			ps.setString(7, account_register.getTel());
			ps.setString(8, account_register.getEmail());
			ps.setString(9, account_register.getOther());
			int ret = ps.executeUpdate();

			if (ret != 0) {
				return true;
			}else {
				return false;
			}

		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return false;
		} finally {
			try {

				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
	}
	public static List<UserBean> getSearch(String search){
		List<UserBean> list3 = new ArrayList<UserBean>();
		Connection con = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Context context = new InitialContext();
			DataSource ds = (DataSource)context.lookup("java:comp/env/jdbc/dicdb");
			con = ds.getConnection();
			ps = con.prepareStatement("SELECT * FROM users WHERE login_id LIKE ? OR l_name LIKE ? OR f_name LIKE ? OR l_name_kana LIKE ? OR f_name_kana LIKE ? OR tel LIKE ? OR email LIKE ? OR other LIKE ?");
			ps.setString(1, search);
			ps.setString(2, search);
			ps.setString(3, search);
			ps.setString(4, search);
			ps.setString(5, search);
			ps.setString(6, search);
			ps.setString(7, search);
			ps.setString(8, search);
			rs = ps.executeQuery();

			while(rs.next()) {
				int id = rs.getInt("id");
				String loginid = rs.getString("login_id");
				String password = rs.getString("password");
				String l_name = rs.getString("l_name");
				String f_name = rs.getString("f_name");
				String l_name_kana = rs.getString("l_name_kana");
				String f_name_kana = rs.getString("f_name_kana");
				String tel = rs.getString("tel");
				String email = rs.getString("email");
				String other = rs.getString("other");
				int flg = rs.getInt("flg");
				UserBean userList = new UserBean(id,loginid,password,l_name,f_name,l_name_kana,f_name_kana,tel,email,other,flg);
				list3.add(userList);
			}
		}catch (Exception ex) {
			System.err.println(ex.getMessage());
			return null;
		} finally {
			try {
				if (rs != null) {
					rs.close();
				}
				if (ps != null) {
					ps.close();
				}
				if (con != null) {
					con.close();
				}
			}catch (Exception ex) {
				System.err.println(ex.getMessage());
			}
		}
		return list3;
	}
}
