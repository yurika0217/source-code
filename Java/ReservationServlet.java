package servlet;

import java.io.IOException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import bean.ReserveBean;
import bean.UserBean;
import dao.ReserveBeanDao;

public class ReservationServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;

	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		request.setCharacterEncoding("UTF-8");
		HttpSession session = request.getSession();
		String nextPage;
		UserBean userId = (UserBean) session.getAttribute("userId");
		if (userId != null) {
			ReserveBean reserve = (ReserveBean) session.getAttribute("reserve");
			//登録済みか確認
			if(ReserveBeanDao.getReserveCheck(reserve)) {
				//予約完了
				session.removeAttribute("reserve");
				session.removeAttribute("room");
				session.removeAttribute("logic");
				nextPage = "reserveok.jsp";
				if (ReserveBeanDao.addReserve(reserve)) {
					//予約成功
					nextPage = "reserveok.jsp";
				} else {
					//予約失敗（DB不具合等）
					nextPage = "reserveerror.jsp";
				}
			}else {
					//重複している場合
					String message = "利用時間内に予約が埋まってる時間帯が含まれています。";
					request.setAttribute("message",message);
				    nextPage = "reserve.jsp";
			}

		} else {
			nextPage = "login.jsp";
		}
		RequestDispatcher rd = request.getRequestDispatcher(nextPage);
		rd.forward(request, response);
	}
}
