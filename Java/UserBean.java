package bean;

import java.io.Serializable;

public class UserBean implements Serializable{
	private static final long serialVersionUID = 1L;
	private String login_id;
	private String password;
	private String l_name;
	private String f_name;
	private String l_name_kana;
	private String f_name_kana;
	private String tel;
	private String email;
	private String other;
	private int id;
	private int flg;

	public UserBean() {
	}

	public UserBean(String login_id, String password, String l_name, String f_name, String l_name_kana, String f_name_kana, String tel, String email) {
		this.login_id = login_id;
		this.password = password;
		this.l_name = l_name;
		this.f_name = f_name;
		this.l_name_kana = l_name_kana;
		this.f_name_kana = f_name_kana;
		this.tel = tel;
		this.email = email;
	}

	public UserBean(String login_id, String password, String l_name, String f_name, String l_name_kana, String f_name_kana, String tel, String email, String other) {
		this.login_id = login_id;
		this.password = password;
		this.l_name = l_name;
		this.f_name = f_name;
		this.l_name_kana = l_name_kana;
		this.f_name_kana = f_name_kana;
		this.tel = tel;
		this.email = email;
		this.other = other;
	}

	public UserBean(String login_id) {
		this.login_id = login_id;
	}

	public UserBean(int id, String login_id, String password, String l_name, String f_name, String l_name_kana, String f_name_kana, String tel, String email, String other, int flg) {
		this.id = id;
		this.login_id = login_id;
		this.password = password;
		this.l_name = l_name;
		this.f_name = f_name;
		this.l_name_kana = l_name_kana;
		this.f_name_kana = f_name_kana;
		this.tel = tel;
		this.email = email;
		this.other = other;
		this.flg = flg;
	}

	public UserBean(int id, String login_id) {
		this.id = id;
		this.login_id = login_id;
	}
	public UserBean(int id, String login_id, String password, String l_name, String f_name, String l_name_kana, String f_name_kana, String tel, String email, String other) {
		this.id = id;
		this.login_id = login_id;
		this.password = password;
		this.l_name = l_name;
		this.f_name = f_name;
		this.l_name_kana = l_name_kana;
		this.f_name_kana = f_name_kana;
		this.tel = tel;
		this.email = email;
		this.other = other;
	}


	public String getLoginId() {
		return login_id;
	}
	public String getPassword() {
		return password;
	}
	public String getLName() {
		return l_name;
	}
	public String getFName() {
		return f_name;
	}
	public String getLNameKana() {
		return l_name_kana;
	}
	public String getFNameKana() {
		return f_name_kana;
	}
	public String getTel() {
		return tel;
	}
	public String getEmail() {
		return email;
	}
	public String getOther() {
		return other;
	}
	public int getId() {
		return id;
	}
	public int getFlg() {
		return flg;
	}
}
