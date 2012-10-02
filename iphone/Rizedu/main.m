//
//  main.m
//  Rizedu
//
//  Created by Tao Xie on 9/22/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "RZAppDelegate.h"
CFAbsoluteTime StartTime;


int main(int argc, char *argv[])
{
    StartTime = CFAbsoluteTimeGetCurrent();
    @autoreleasepool {
        return UIApplicationMain(argc, argv, nil, NSStringFromClass([RZAppDelegate class]));
    }
}
