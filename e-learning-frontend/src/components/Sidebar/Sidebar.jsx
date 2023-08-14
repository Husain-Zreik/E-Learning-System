import {SiRedux} from "react-icons/si"
import {AiFillHome} from "react-icons/ai"
import {BsFillChatLeftTextFill} from "react-icons/bs"
import {MdGrade} from "react-icons/md"
import { FiLogOut } from "react-icons/fi"
import "./style.css"

const Sidebar = () => {
    return (
        <div className="sidebar">
            <div className="logo">
                <SiRedux size={40}/>
            </div>
            <div className="mid">
                <div>
                    <AiFillHome size={32}/>
                </div>
                <div>
                    <BsFillChatLeftTextFill size={32}/>
                </div>
                <div>
                    <MdGrade size={32}/>
                </div>
            </div>
            <div className="bottom">
                <FiLogOut size={35} />
            </div>
        </div>
    );
}

export default Sidebar