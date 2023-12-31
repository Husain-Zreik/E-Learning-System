import React from "react";
import "./style.css";
import { Outlet, useNavigate } from "react-router-dom";
import {
  AiFillPlusCircle,
  AiFillSetting,
} from "react-icons/ai";
import { CgDisplayFullwidth } from "react-icons/cg";
import Sidebar from "../../components/common/Sidebar/Sidebar";

function AdminLayout() {
  const navigate = useNavigate();
  const sidebar = [
    {
      svg: <AiFillPlusCircle size={32} />,
      onclick: () => navigate("/admin/create"),
    },
    {
      svg: <CgDisplayFullwidth size={32} />,
      onclick: () => navigate("/admin/display"),
    },
    {
      svg: <AiFillSetting size={32} />,
      onclick: () => navigate("/admin/settings"),
    },
  ];
  return (
    <div className="admin-layout app dark">
      <Sidebar sidebarContent={sidebar} />
      <div className="admin-outlet">
        <Outlet />
      </div>
    </div>
  );
}

export default AdminLayout
