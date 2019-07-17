<?php

namespace App\Http\Controllers;

use App\OfferUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class OfferUserController extends Controller
{
    /**
     * Turn true attribute activate of OfferUser.
     *
     * @param Request $request
     * @return Response
     */

    public function activateOffer(Request $request)
    {
        $request->validate([
            'id_offer_user' => 'required|numeric'
        ]);

        /** @var User $user */
        $id_offer_user = OfferUser::find($request->id_offer_user);

        $id_offer_user->activate = 1;
        $id_offer_user->save();

        return response()->json("OK", 200);;
    }

    /**
     * Returns the offers of a specific user.
     *
     * @param int $idUser
     * @return Response
     */
    public function getOffersOfUser($idUser)
    {
        /** @var OfferUser */
        $offersOfUser = OfferUser::where('user_id', $idUser)->get();

        foreach ($offersOfUser as $offer) {
            $offersOfUser->offer = $offer->offer;
        }
        return response()->json($offersOfUser, 200);
    }

    /**
     * Save in DB offer_user table with unic code.
     *
     * @param Request $request
     * @return Response
     */

    public function saveUserCode(Request $request)
    {
        $request->validate([
            'idUser' => 'required|numeric',
            'idOffer' => 'required|numeric',
        ]);

        $unique_code = strtoupper(Str::random(9));

        while ($this->checkIfCodeExists($unique_code)) {
            $unique_code = strtoupper(Str::random(9));
        }

        $offerUser = new OfferUser([
            'user_id' => $request->idUser,
            'offer_id' => $request->idOffer,
            'code' => $unique_code,
            'activate' => false
        ]);

        $offerUser->save();
        return response()->json($unique_code, 200);
    }

    /**
     * Check if the code exists in the database.
     *
     * @param string $code
     * @return bool
     */
    private function checkIfCodeExists($code)
    {
        $usersOffers = OfferUser::all();
        foreach ($usersOffers as $userOffer) {
            if ($code === $userOffer->code) {
                return true;
            };
        }

        return false;
    }
}
